<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CashAccountModel;
use App\Models\CashBookModel;
use App\Models\CashReciptVoucherModel;
use App\Models\Category;
use App\Models\ModelTable;
use App\Models\PartsModel;
use App\Models\ProductLoss;
use App\Models\StockModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashReceiptVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:cash-receipt-voucher-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:cash-receipt-voucher-create', ['only' => ['create', 'store']]);
    }

    public function index(Request $request)
    {
        //        $datas = ModelTable::all();
        //        $brands = Brand::all();
        //        $categorys = Category::all();
        $ar = json_decode($request->array);
        $pagination_number = empty($ar) ? 30 : 100000000;
        $auth = Auth::user();
        $datas = DB::table('cash_receipt_voucher')
            ->where('cash_receipt_voucher.company_id', $auth->company_id)
            ->leftJoin('users', 'users.id', '=', 'cash_receipt_voucher.jrv_user_id')
            ->where('users.company_id', $auth->company_id)
            ->leftJoin('cash_account', 'cash_account.ca_id', '=', 'cash_receipt_voucher.jrv_cash_account')
            ->where('cash_account.company_id', $auth->company_id);
        // ->orderBy('jrv_id', 'Desc');

        $account_name = $request->account_name;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $start = date('Y-m-d', strtotime($from_date));

        $end = date('Y-m-d', strtotime($to_date));
        $query = $datas;

        if (isset($request->account_name)) {
            $query->Where('cash_account.ca_id', '=', $request->account_name);
        }

        if (!empty($from_date) && !empty($to_date)) {
            $query->whereDate('cash_receipt_voucher.jrv_created_at', '>=', $start)->whereDate('cash_receipt_voucher.jrv_created_at', '<=', $end);
        } elseif (isset($request->from_date)) {
            $query->whereDate('cash_receipt_voucher.jrv_created_at', '=', $start);
        } elseif (isset($request->to_date)) {
            $query->whereDate('cash_receipt_voucher.jrv_created_at', '=', $end);
        }
        $cash_title = DB::table('cash_account')
            ->where('cash_account.company_id', $auth->company_id)
            ->leftJoin('users', 'users.id', '=', 'cash_account.ca_user_id')
            ->where('users.company_id', $auth->company_id)
            ->get();
        // $query = $query->get();
        $query = $query->orderBy('jrv_id', 'DESC')->paginate($pagination_number);

        return view('cash_receipt_voucher/cash_receipt_voucher_list', compact('cash_title', 'account_name', 'from_date', 'to_date', 'query'))->with('pageTitle', 'Cash Receipt Voucher List');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = Auth::user();
        $cash = CashAccountModel::where('company_id', $auth->company_id)->get();
        $count = CashReciptVoucherModel::where('company_id', $auth->company_id)->count('jrv_inv_id');

        // If no records are found, set $count to 1, otherwise increment by 1
        $count = $count ? $count + 1 : 1;

        // dd($count);

        return view('cash_receipt_voucher/add_cash_receipt_voucher', compact('cash','count'))->with('pageTitle', 'Create Cash Receipt Voucher');
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
            'cash_account' => 'required',
            'received_by' => 'required',
            'remarks' => 'required',
            'amount' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $auth = Auth::user();
            $crv = new CashReciptVoucherModel();
            $crv->jrv_cash_account = $request->cash_account;
            $crv->jrv_amount = $request->amount;
            $crv->jrv_remarks = $request->remarks;
            $crv->jrv_inv_id = $request->inv_id;
            $crv->jrv_user_id = $auth->id;
            $crv->company_id = $auth->company_id;
            $crv->jrv_recieved_by = $request->received_by;

            // coding from shahzaib start
            $tbl_var_name = 'crv';
            $prfx = 'jrv';
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->get_ip();

            $brwsr_col = $prfx . '_browser_info';
            $ip_col = $prfx . '_ip_address';
            $updt_date_col = $prfx . '_updated_at';

            $$tbl_var_name->$brwsr_col = $brwsr_rslt;
            $$tbl_var_name->$ip_col = $clientIP;
            $$tbl_var_name->$updt_date_col = Carbon::now();
            // coding from shahzaib end

            //        $crv->bra_created_at=Carbon::now()->toDateTimeString();
            //        $crv->bra_updated_at=$auth->id;
            $crv->save();

            //        store in parts table
            $pat = CashAccountModel::where('ca_id', '=', $request->cash_account)
                ->where('company_id', $auth->company_id)
                ->first();
            $pat->ca_balance = $pat->ca_balance + $request->amount;
            $pat->save();

            //        add cash book data
            $last_qty = CashBookModel::where('cb_ca_id', '=', $request->cash_account)
                ->where('company_id', $auth->company_id)
                ->OrderBy('cb_id', 'DESC')
                ->first();

            if ($last_qty == null) {
                $new_qty = $request->amount;
            } else {
                $new_qty = $last_qty->cb_total + $request->amount;
            }

            $cash_book = new CashBookModel();
            $cash_book->cb_ca_id = $crv->jrv_cash_account;
            $cash_book->cb_user_id = $auth->id;
            $cash_book->company_id = $auth->company_id;
            $cash_book->cb_type = 'Cash_Receipt';
            $cash_book->cb_type_id = $crv->jrv_inv_id;
            $cash_book->cb_in = $request->amount;
            $cash_book->cb_total = $new_qty;
            $cash_book->save();
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
        //
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
        //
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
