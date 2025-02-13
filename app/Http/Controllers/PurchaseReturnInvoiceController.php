<?php

namespace App\Http\Controllers;

use App\Models\CashAccountModel;
use App\Models\CashBookModel;
use App\Models\CreditPurchaseInvoiceModel;
use App\Models\CreditPurchaseReturnInvoiceModel;
use App\Models\CreditSaleInvoiceModel;
use App\Models\PartsModel;
use App\Models\PartyModel;
use App\Models\ProductsModel;
use App\Models\PurchaseInvoiceItemsModel;
use App\Models\PurchaseInvoiceModel;
use App\Models\PurchaseReturnInvoiceModel;
use App\Models\StockModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\b;

class PurchaseReturnInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:purchase-invoice-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:purchase-invoice-create', ['only' => ['create', 'store']]);
    }

    public function index(Request $request)
    {
        $ar = json_decode($request->array);
        $pagination_number = empty($ar) ? 30 : 100000000;
        $auth = Auth::user();
        $datas = DB::table('purchase_invoice')
            ->where('purchase_invoice.company_id', $auth->company_id)
            ->leftJoin('cash_account', 'cash_account.ca_id', '=', 'purchase_invoice.pi_cash_account')
            ->where('cash_account.company_id', $auth->company_id)
            ->leftJoin('party', 'party.party_id', '=', 'purchase_invoice.pi_party_id')
            ->where('party.company_id', $auth->company_id);
        // ->orderBy('pi_id','Desc');

        $job_no = $request->job_no;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $start = date('Y-m-d', strtotime($from_date));

        $end = date('Y-m-d', strtotime($to_date));
        $query = $datas;

        if (isset($request->job_no)) {
            $query->Where('purchase_invoice.pi_inv_id', '=',  $request->job_no);
        }

        if (!empty($from_date) && !empty($to_date)) {
            $query->whereDate('purchase_invoice.pi_created_at', '>=', $start)->whereDate('purchase_invoice.pi_created_at', '<=', $end);
        } elseif (isset($request->from_date)) {
            $query->whereDate('purchase_invoice.pi_created_at', '=', $start);
        } elseif (isset($request->to_date)) {
            $query->whereDate('purchase_invoice.pi_created_at', '=', $end);
        }

        // $query = $query->get();
        $query = $query->orderBy('pi_id', 'DESC')->paginate($pagination_number);

        return view('purchase_return_invoice/purchase_invoice_list', compact('job_no', 'from_date', 'to_date', 'query'))->with('pageTitle', 'Purchase Invoice List');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = Auth::user();
        $purchase_invoice = PurchaseInvoiceModel::where('purchase_invoice.company_id', $auth->company_id)
//            ->leftjoin('purchase_invoice_items', 'purchase_invoice_items.pii_pi_id', '=', 'purchase_invoice.pi_id')
            ->get();
//        dd($purchase_invoice);
        $cash = CashAccountModel::where('company_id', $auth->company_id)->get();
        $parts = ProductsModel::
//        where('par_status', '=', 'Opening')
//            ->
            where('company_id', $auth->company_id)
            ->get();
        $party = PartyModel::where('company_id', $auth->company_id)->get();

        $count = PurchaseReturnInvoiceModel::where('company_id', $auth->company_id)->max('pri_inv_id');

        // If no records are found, set $count to 1, otherwise increment by 1
        $count = $count ? $count + 1 : 1;
        // dd($count);

        return view('purchase_return_invoice/add_purchase_invoice', compact('count','cash', 'parts', 'party','purchase_invoice'))->with('pageTitle', 'Create Purchase Invoice');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        global $pi_id;

        $this->validate($request, [
            'account' => 'required',
            'party' => 'required',
            'total_item' => 'required|integer|min:1',
            'grand_total' => 'required|integer|min:0',
            'p_amount' => 'required|integer|min:0',
            'remaining' => 'required|integer|min:0',
            'st_qty.*' => 'required|integer|min:1',
            'qty.*' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $pi_id) {
            $auth = Auth::user();

            $requested_arrays = $request->parts;

            //        add  data to purchase invoice
            $pr = new PurchaseReturnInvoiceModel();
            $pr->pri_cash_account = $request->account;
            $pr->pri_party_id = $request->party;
            $pr->pri_inv_id = $request->inv_id;
            $pr->pri_grand_total = $request->grand_total;
            $pr->pri_total_items = $request->total_item;
            $pr->pri_remarks = $request->remarks;
            $pr->pri_user_id = $auth->id;
            $pr->company_id = $auth->company_id;

            $pr->pri_amount_pay = $request->p_amount;
            $pr->pri_remaining = $request->remaining;

            if ($request->remaining == 0) {
                $pr->pri_status = 'Paid';
            } else {
                $pr->pri_status = 'Credit';
            }

            // coding from shahzaib start
            $tbl_var_name = 'pr';
            $prfx = 'pri';
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->get_ip();

            $brwsr_col = $prfx . '_browser_info';
            $ip_col = $prfx . '_ip_address';
            $updt_date_col = $prfx . '_updated_at';

            $$tbl_var_name->$brwsr_col = $brwsr_rslt;
            $$tbl_var_name->$ip_col = $clientIP;
            $$tbl_var_name->$updt_date_col = Carbon::now();
            // coding from shahzaib end

            $pr->save();

            //            add into credit sale invoice

            $credit_purchase_invoice = new CreditPurchaseReturnInvoiceModel();
            $credit_purchase_invoice->cpri_cash_account = $request->account;
            $credit_purchase_invoice->cpri_party_id = $request->party;
            $credit_purchase_invoice->cpri_pi_id = $pr->pi_id;
            $credit_purchase_invoice->cpri_inv_id = $pr->pi_inv_id;
            $credit_purchase_invoice->cpri_amount_paid = $request->p_amount;
            $credit_purchase_invoice->cpri_real_estimated_cost = $request->grand_total;
            $credit_purchase_invoice->cpri_estimated_cost = $request->remaining;
            $credit_purchase_invoice->cpri_remaining_cost = $request->remaining;
            $credit_purchase_invoice->cpri_discount = 0;
            $credit_purchase_invoice->cpri_remarks = $request->remarks;
            $credit_purchase_invoice->cpri_user_id = $auth->id;
            $credit_purchase_invoice->company_id = $auth->company_id;

            if ($request->remaining == 0) {
                $credit_purchase_invoice->cpri_status = 'Paid';
            } else {
                $credit_purchase_invoice->cpri_status = 'Credit';
            }

            $t_amount_pay = $request->real_estimated_cost - $request->remaining_estimated_cost;

            // coding from shahzaib start
            $tbl_var_name = 'credit_purchase_return_invoice';
            $prfx = 'cpri';
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->get_ip();

            $brwsr_col = $prfx . '_browser_info';
            $ip_col = $prfx . '_ip_address';

            $$tbl_var_name->$brwsr_col = $brwsr_rslt;
            $$tbl_var_name->$ip_col = $clientIP;
            // coding from shahzaib end
            $credit_purchase_invoice->save();

            //        add cash book data
            $last_amount = CashBookModel::where('cb_ca_id', '=', $request->account)
                ->where('company_id', $auth->company_id)
                ->OrderBy('cb_id', 'DESC')
                ->first();

            if ($last_amount == null) {
                $new_amount = $request->p_amount;
            } else {
                $new_amount = $last_amount->cb_total + $request->p_amount;
            }

            $cash_book = new CashBookModel();
            $cash_book->cb_ca_id = $request->account;
            $cash_book->cb_user_id = $auth->id;
            $cash_book->company_id = $auth->company_id;
            $cash_book->cb_type = 'Purchase_return_Invoice';
            $cash_book->cb_type_id = $pr->pi_inv_id;
            $cash_book->cb_out = $request->p_amount;
            $cash_book->cb_total = $new_amount;
            $cash_book->save();

            //         add data to Cash Account table
            $pat = CashAccountModel::where('ca_id', '=', $request->account)
                ->where('company_id', $auth->company_id)
                ->first();
            $pat->ca_balance = $pat->ca_balance + $request->p_amount;
            $pat->save();

            //        add  data to purchase invoice items
            foreach ($requested_arrays as $index => $requested_array) {
                $purchase_items = new PurchaseInvoiceItemsModel();
                $purchase_items->pii_user_id = $auth->id;
                $purchase_items->company_id = $auth->company_id;
                $purchase_items->pii_pi_id = $pr->pi_id;
                $purchase_items->pii_inv_id = $pr->pi_inv_id;
                $purchase_items->pii_part_name = $request->parts[$index];
                $purchase_items->pii_qty = $request->qty[$index];
                $purchase_items->pii_rate = $request->rate[$index];
                $purchase_items->pii_discount = $request->discount[$index];
                $purchase_items->pii_amount = $request->tamount[$index];

                $purchase_items->save();

                $pat = ProductsModel::where('par_id', '=', $request->parts[$index])
                    ->where('company_id', $auth->company_id)
                    ->first();
                $pat->par_total_qty = $pat->par_total_qty - $request->qty[$index];
                $pat->par_purchase_price = $request->rate[$index];
                $pat->save();

                //        add stock data
                $last_qty = StockModel::where('sto_par_id', '=', $request->parts[$index])
                    ->where('company_id', $auth->company_id)
                    ->OrderBy('sto_id', 'DESC')
                    ->first();

                if ($last_qty == null) {
                    $new_qty = $request->qty[$index];
                } else {
                    $new_qty = $last_qty->sto_total - $request->qty[$index];
                }

                $stock = new StockModel();
                $stock->sto_par_id = $request->parts[$index];
                $stock->sto_user_id = $auth->id;
                $stock->company_id = $auth->company_id;
                $stock->sto_type = 'Purchase Return Invoice';
                $stock->sto_type_id = $pr->pi_inv_id;
                $stock->sto_in = $request->qty[$index];
                $stock->sto_in_rate = $request->rate[$index];
                $stock->sto_in_discount = $request->discount[$index];
                $stock->sto_in_amount = $request->tamount[$index];
                $stock->sto_total = $new_qty;
                $stock->save();
            }

            //        store in parts table
            //        foreach ($requested_arrays as $index => $requested_array) {

            //        }
            global $pi_id;
            $pi_id = $pr->prii_inv_id;
        });
        return redirect()
            ->back()
            ->with('pi_id', $pi_id);
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
