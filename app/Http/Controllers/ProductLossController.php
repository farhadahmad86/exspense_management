<?php

namespace App\Http\Controllers;

use App\Models\JobCloseModel;
use App\Models\JobInformationModel;
use App\Models\PartsModel;
use App\Models\ProductLoss;
use App\Models\ProductsModel;
use App\Models\StockModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductLossController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:product-loss-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-loss-create', ['only' => ['create', 'store']]);
    }

    public function index(Request $request)
    {
        $ar = json_decode($request->array);
        $pagination_number = empty($ar) ? 30 : 100000000;
        // $datas = ProductLoss::all();
        $auth = Auth::user();
        $datas = DB::table('product_loss')
            ->where('product_loss.company_id', $auth->company_id)
            ->leftJoin('users', 'users.id', '=', 'product_loss.pl_user_id')
            ->where('users.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'product_loss.pl_part_id')
            ->where('products.company_id', $auth->company_id);
        // ->orderBy('pl_id','Desc');

        $part_name = $request->part_name;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $start = date('Y-m-d', strtotime($from_date));

        $end = date('Y-m-d', strtotime($to_date));
        $query = $datas;

        if (isset($request->part_name)) {
            $query->where('products.par_id', '=', $request->part_name);
        }

        if (!empty($from_date) && !empty($to_date)) {
            $query->whereDate('product_loss.pl_created_at', '>=', $start)->whereDate('product_loss.pl_created_at', '<=', $end);
        } elseif (isset($request->from_date)) {
            $query->whereDate('product_loss.pl_created_at', '=', $start);
        } elseif (isset($request->to_date)) {
            $query->whereDate('product_loss.pl_created_at', '=', $end);
        }

        $parts_title = ProductsModel::where('par_status', 'Opening')
            ->where('company_id', $auth->company_id)
            ->get();

        // $query = $query->get();
        $query = $query->orderBy('pl_id', 'DESC')->paginate($pagination_number);

        return view('product_loss/product_loss_list', compact('parts_title', 'part_name', 'from_date', 'to_date', 'query'))->with('pageTitle', 'Product Loss List');
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
        $count = ProductLoss::where('company_id', $auth->company_id)->max('pl_inv_id');

        // If no records are found, set $count to 1, otherwise increment by 1
        $count = $count ? $count + 1 : 1;
        // dd($count);
        return view('product_loss/add_product_loss', compact('parts','count'))->with('pageTitle', 'Create Product Loss');
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
//            'st_qty' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            // $this->validation($request);

            $auth = Auth::user();
            $pl = new ProductLoss();
            $pl->pl_part_id = $request->part_name;
            $pl->pl_qty = $request->parts_qty;
            $pl->pl_remarks = $request->remarks;
            $pl->pl_inv_id = $request->inv_id;
            $pl->pl_user_id = $auth->id;
            $pl->company_id = $auth->company_id;

            // coding from shahzaib start
            $tbl_var_name = 'pl';
            $prfx = 'pl';
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->get_ip();

            $brwsr_col = $prfx . '_browser_info';
            $ip_col = $prfx . '_ip_address';
            $updt_date_col = $prfx . '_updated_at';

            $$tbl_var_name->$brwsr_col = $brwsr_rslt;
            $$tbl_var_name->$ip_col = $clientIP;
            $$tbl_var_name->$updt_date_col = Carbon::now();
            // coding from shahzaib end

            //        $pl->bra_created_at=Carbon::now()->toDateTimeString();
            //        $pl->bra_updated_at=$auth->id;
            $pl->save();

            //        update in parts table
            $pat = ProductsModel::where('par_id', '=', $request->part_name)
                ->where('company_id', $auth->company_id)
                ->first();
            $pat->par_total_qty = $pat->par_total_qty - $request->parts_qty;
            $pat->save();

            //        add stock data
            $last_qty = StockModel::where('sto_par_id', '=', $request->part_name)
                ->where('company_id', $auth->company_id)
                ->OrderBy('sto_id', 'DESC')
                ->first();
            $new_qty = $last_qty->sto_total - $request->parts_qty;

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
            $stock->sto_type = 'Loss';
            $stock->sto_type_id = $pl->pl_inv_id;
            $stock->sto_out = $request->parts_qty;
            $stock->sto_out_rate = $part_rate['par_purchase_price'];
            $stock->sto_out_amount = $part_amount;
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
        $product_loss = ProductLoss::where('pl_id', '=', $id)
            ->where('company_id', $auth->company_id)
            ->first();
        return view('product_loss/edit_product_loss ', compact('product_loss'))->with('pageTitle', 'Edit Product Loss');
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
            $product_loss = ProductLoss::where('pl_id', '=', $id)->first();
            $product_loss->pl_name = $request->part_name;
            $product_loss->pl_qty = $request->parts_qty;
            $product_loss->pl_remarks = $request->remarks;
            $product_loss->pl_user_id = $auth->id;
            $product_loss->company_id = $auth->company_id;
            // coding from shahzaib start
            $tbl_var_name = 'product_loss';
            $prfx = 'pl';
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->get_ip();

            $brwsr_col = $prfx . '_browser_info';
            $ip_col = $prfx . '_ip_address';
            $updt_date_col = $prfx . '_updated_at';

            $$tbl_var_name->$brwsr_col = $brwsr_rslt;
            $$tbl_var_name->$ip_col = $clientIP;
            $$tbl_var_name->$updt_date_col = Carbon::now('GMT+5');
            // coding from shahzaib end
            $product_loss->save();
        });
        return redirect()
            ->route('product_loss.index')
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
