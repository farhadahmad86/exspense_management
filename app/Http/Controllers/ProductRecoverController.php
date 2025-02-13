<?php

namespace App\Http\Controllers;

use App\Models\PartsModel;
use App\Models\ProductLoss;
use App\Models\ProductRecover;
use App\Models\ProductsModel;
use App\Models\StockModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductRecoverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:product-recover-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-recover-create', ['only' => ['create', 'store']]);
    }

    public function index(Request $request)
    {
        $ar = json_decode($request->array);
        $pagination_number = empty($ar) ? 30 : 100000000;
        // $datas = ProductRecover::all();
        $auth = Auth::user();
        $datas = DB::table('product_recover')
            ->where('product_recover.company_id', $auth->company_id)
            ->leftJoin('users', 'users.id', '=', 'product_recover.pr_user_id')
            ->where('users.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'product_recover.pr_part_id')
            ->where('products.company_id', $auth->company_id);
        // ->orderBy('pr_id','Desc');

        $part_name = $request->part_name;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $start = date('Y-m-d', strtotime($from_date));

        $end = date('Y-m-d', strtotime($to_date));
        $query = $datas;

        if (isset($request->part_name)) {
            $query->orWhere('products.par_name', 'like', '%' . $request->part_name . '%');
        }

        if (!empty($from_date) && !empty($to_date)) {
            $query->whereDate('product_recover.pr_created_at', '>=', $start)->whereDate('product_recover.pr_created_at', '<=', $end);
        } elseif (isset($request->from_date)) {
            $query->whereDate('product_recover.pr_created_at', '=', $start);
        } elseif (isset($request->to_date)) {
            $query->whereDate('product_recover.pr_created_at', '=', $end);
        }

        $parts_title = ProductsModel::where('par_status', 'Opening')->get();
        // $query = $query->get();
        $query = $query->orderBy('pr_id', 'DESC')->paginate($pagination_number);

        return view('product_recover/product_recover_list', compact('parts_title', 'part_name', 'from_date', 'to_date', 'query'))->with('pageTitle', 'Product Recover List');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = Auth::user();
        $parts = ProductsModel::where('company_id', $auth->company_id)->get(); //where("par_status","=","Opening")->get();
        $count = ProductRecover::where('company_id', $auth->company_id)->max('pr_inv_id');

        // If no records are found, set $count to 1, otherwise increment by 1
        $count = $count ? $count + 1 : 1;
        // dd($count);
        return view('product_recover/add_product_recover', compact('parts', 'count'))->with('pageTitle', 'Create Product Recover');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'part_name' => 'required',
            'parts_qty' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            // $this->validation($request);

            $auth = Auth::user();
            $pr = new ProductRecover();
            $pr->pr_part_id = $request->part_name;
            $pr->pr_qty = $request->parts_qty;
            $pr->pr_remarks = $request->remarks;
            $pr->pr_inv_id = $request->inv_id;
            $pr->pr_user_id = $auth->id;
            $pr->company_id = $auth->company_id;

            // coding from shahzaib start
            $tbl_var_name = 'pr';
            $prfx = 'pr';
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->get_ip();

            $brwsr_col = $prfx . '_browser_info';
            $ip_col = $prfx . '_ip_address';
            $updt_date_col = $prfx . '_updated_at';

            $$tbl_var_name->$brwsr_col = $brwsr_rslt;
            $$tbl_var_name->$ip_col = $clientIP;
            $$tbl_var_name->$updt_date_col = Carbon::now();
            // coding from shahzaib end

            //        $pr->bra_created_at=Carbon::now()->toDateTimeString();
            //        $pr->bra_updated_at=$auth->id;
            $pr->save();

            //        store in parts table
            $pat = ProductsModel::where('par_id', '=', $request->part_name)
                ->where('company_id', $auth->company_id)
                ->first();
            $pat->par_total_qty = $pat->par_total_qty + $request->parts_qty;
            $pat->save();

            //        add stock data
            $last_qty = StockModel::where('sto_par_id', '=', $request->part_name)
                ->where('company_id', $auth->company_id)
                ->OrderBy('sto_id', 'DESC')
                ->first();
            $new_qty = $last_qty->sto_total + $request->parts_qty;

            //            get part rate and amount
            $part_rate = ProductsModel::select('par_purchase_price')
                ->where('company_id', $auth->company_id)
                ->where('par_id', '=', $request->part_name)
                ->first();
            $part_amount = $request->parts_qty * $part_rate['par_purchase_price'];

            $stock = new StockModel();
            $stock->sto_par_id = $request->part_name;
            $stock->sto_user_id = $auth->id;
            $stock->company_id = $auth->company_id;
            $stock->sto_type = 'Recover';
            $stock->sto_type_id = $pr->pr_inv_id;
            $stock->sto_in = $request->parts_qty;
            $stock->sto_in_rate = $part_rate['par_purchase_price'];
            $stock->sto_in_amount = $part_amount;
            $stock->sto_total = $new_qty;
            $stock->save();
        });

        return redirect()
            ->back()
            ->with('success', 'Successfully Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $auth = Auth::user();
        $product_recover = ProductRecover::where('pr_id', '=', $id)
            ->where('company_id', $auth->company_id)
            ->first();
        return view('product_recover/edit_product_recover ', compact('product_recover'))->with('pageTitle', 'Edit Product Recover');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $auth = Auth::user();
            $product_recover = ProductRecover::where('pr_id', '=', $id)->first();
            $product_recover->pr_name = $request->part_name;
            $product_recover->pr_qty = $request->parts_qty;
            $product_recover->pr_remarks = $request->remarks;
            $product_recover->pr_user_id = $auth->id;
            $product_recover->company_id = $auth->company_id;
            // coding from shahzaib start
            $tbl_var_name = 'product_recover';
            $prfx = 'pr';
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->get_ip();

            $brwsr_col = $prfx . '_browser_info';
            $ip_col = $prfx . '_ip_address';
            $updt_date_col = $prfx . '_updated_at';

            $$tbl_var_name->$brwsr_col = $brwsr_rslt;
            $$tbl_var_name->$ip_col = $clientIP;
            $$tbl_var_name->$updt_date_col = Carbon::now('GMT+5');
            // coding from shahzaib end
            $product_recover->save();
        });
        return redirect()
            ->route('product_recover.index')
            ->with('success', 'Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
