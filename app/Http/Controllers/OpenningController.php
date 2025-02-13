<?php

namespace App\Http\Controllers;

use App\Models\IssuePartsToJobItemsModel;
use App\Models\IssuePartsToJobModel;
use App\Models\ProductsModel;
use App\Models\StockModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OpenningController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:openinning-stock-create', ['only' => ['add_openning','store_openning']]);
    }


    public function add_openning(Request $request)
    {
        // Retrieve the authenticated user
        $auth = Auth::user();

        // Capture the product name from the request
        $product_name = $request->part_name;

        // Build the query for ProductsModel with company_id filter
        $parts = ProductsModel::where('company_id', $auth->company_id);

        // Check if part_name is set in the request, and apply the filter
        if ($product_name) {
            $parts->where('products.par_id', '=', $product_name);
        }

        // Paginate the result
        $parts = $parts->paginate(30);

        // Retrieve all product titles
        $products_title = ProductsModel::where('company_id', $auth->company_id)->get();

        // Return the view with the compacted variables
        return view('open_stock/openning_stock',compact('parts','products_title','product_name'))->with('pageTitle', 'Create Opening Stock');
    }


    public function openning_list(Request $request)
    {
        $datas = ProductsModel::all();

        $datas = DB::table('opennings')
            ->leftJoin('users', 'users.id','=', 'opennings.bra_user_id')
            ->orderBy('bra_id','Desc')
            ->get();

        $query = $datas;

        return view('openning/openning_list', compact(  'query'))->with('pageTitle', 'Openning Stock List');
    }

    public function store_openning(Request $request)
    {
        DB::transaction(function () use ($request) {
            $auth = Auth::user();

            $requested_arrays = $request->part_id;
            foreach ($requested_arrays as $index => $requested_array) {
                if ($request->qty[$index] == null) {
                    continue; // Skip if quantity is null
                } else {
                    // Check if there's already an "Opening" entry for this product
                    $existing_opening = StockModel::where('sto_par_id', '=', $request->part_id[$index])
                        ->where('sto_type', '=', 'Openning')
                        ->where('company_id', $auth->company_id)
                        ->exists();
                    if ($existing_opening) {
                        continue; // Skip this product if "Opening" already exists
                    }
                    // Check if the product has any existing stock entries
                    $existing_stock = StockModel::where('sto_par_id', '=', $request->part_id[$index])
                        ->where('company_id', $auth->company_id)
                        ->exists();

                    if ($existing_stock) {
                        continue; // Skip this product if  stock exists for it
                    }
                    dump($existing_opening,$existing_stock);

                    // Get the product's purchase price
                    $part_rate = ProductsModel::select('par_purchase_price')
                        ->where('par_id', '=', $request->part_id[$index])
                        ->where('company_id', $auth->company_id)
                        ->first();

                    $part_amount = $request->qty[$index] * $part_rate['par_purchase_price'];

                    // Update in ProductsModel
                    $pat = ProductsModel::where("par_id", "=", $request->part_id[$index])
                        ->where('company_id', $auth->company_id)
                        ->first();
                    $pat->par_total_qty = $request->qty[$index];
                    $pat->par_status = "Opening";
                    $pat->save();

                    // Get the last stock total
                    $last_qty = StockModel::where("sto_par_id", "=", $request->part_id[$index])
                        ->where('company_id', $auth->company_id)
                        ->orderBy("sto_id", 'DESC')
                        ->first();
                    $new_qty = $last_qty ? $last_qty->sto_total + $request->qty[$index] : $request->qty[$index];

                    // Add new stock entry
                    $stock = new StockModel();
                    $stock->sto_par_id = $request->part_id[$index];
                    $stock->sto_user_id = $auth->id;
                    $stock->company_id = $auth->company_id;
                    $stock->sto_type = "Openning";
                    $stock->sto_in = $request->qty[$index];
                    $stock->sto_in_rate = $part_rate['par_purchase_price'];
                    $stock->sto_in_amount = $part_amount;
                    $stock->sto_total = $new_qty;
                    $stock->save();
                }
            }
        });

        return redirect()->back()->with('success', 'Successfully Saved');
    }

}
