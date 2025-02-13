<?php

namespace App\Http\Controllers;

use App\Models\CashAccountModel;
use App\Models\CashBookModel;
use App\Models\CompanyProfile;
use App\Models\CreditPurchaseInvoiceModel;
use App\Models\JobInformationModel;
use App\Models\PurchaseInvoiceModel;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreditPurchaseController extends Controller
{
    function __construct()
    {
//        $this->middleware('permission:detail-purchase-invoice-list', ['only' => ['credit_purchase_list']]);
        $this->middleware('permission:purchase-invoice-edit', ['only' => ['add_credit_purchase', 'store_credit_purchase']]);
    }

    public function credit_purchase_list(Request $request)
    {
        $ar = json_decode($request->array);
        $pagination_number = empty($ar) ? 30 : 100000000;
        $auth = Auth::user();
        $datas = DB::table('credit_purchase_invoice')
            ->where('credit_purchase_invoice.company_id', $auth->company_id)
            ->leftJoin('users', 'users.id', '=', 'credit_purchase_invoice.cpi_user_id')
            ->where('users.company_id', $auth->company_id)
            ->leftJoin('cash_account', 'cash_account.ca_id', '=', 'credit_purchase_invoice.cpi_cash_account')
            ->where('cash_account.company_id', $auth->company_id)
            ->leftJoin('party', 'party.party_id', '=', 'credit_purchase_invoice.cpi_party_id')
            ->where('party.company_id', $auth->company_id);
        // ->orderBy('cpi_id','Desc');

        $status = $request->status;
        $purchase_invoice = $request->purchase_invoice;
        $invoice = $request->invoice;
        $account_name = $request->account_name;
        $party = $request->party;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $start = date('Y-m-d', strtotime($from_date));

        $end = date('Y-m-d', strtotime($to_date));
        $query = $datas;

        if (isset($request->status)) {
            $query->where('credit_purchase_invoice.cpi_status', '=', $request->status);
        }

        if (isset($request->purchase_invoice)) {
            $query->where('credit_purchase_invoice.cpi_inv_id', '=', $request->purchase_invoice);
        }

        if (isset($request->invoice)) {
            $query->where('credit_purchase_invoice.cpi_inv_id', '=', $request->invoice);
        }

        if (isset($request->account_name)) {
            $query->where('cash_account.ca_name', 'like', '%' . $request->account_name . '%');
        }

        if (isset($request->party)) {
            $query->where('party.party_name', 'like', '%' . $request->party . '%');
        }

        if (!empty($from_date) && !empty($to_date)) {
            $query->whereDate('credit_purchase_invoice.cpi_created_at', '>=', $start)->whereDate('credit_purchase_invoice.cpi_created_at', '<=', $end);
        } elseif (isset($request->from_date)) {
            $query->whereDate('credit_purchase_invoice.cpi_created_at', '=', $start);
        } elseif (isset($request->to_date)) {
            $query->whereDate('credit_purchase_invoice.cpi_created_at', '=', $end);
        }

        $cash_title = DB::table('cash_account')
            ->where('cash_account.company_id', $auth->company_id)
            ->leftJoin('users', 'users.id', '=', 'cash_account.ca_user_id')
            ->where('users.company_id', $auth->company_id)
            ->get();
        // $query = $query->get();
        $query = $query->orderBy('cpi_id', 'DESC')->paginate($pagination_number);
        //        dd($datas);

        return view('credit_purchase/credit_purchase_list', compact('cash_title', 'status', 'from_date', 'to_date', 'query', 'account_name', 'party', 'purchase_invoice', 'invoice'))->with('pageTitle', 'Purchase Invoice Detail List');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_credit_purchase($id)
    {
        $auth = Auth::user();
        $cash_accounts = CashAccountModel::where('cash_account.company_id', $auth->company_id)->get();
        $credit_purchase_invoice_detail = PurchaseInvoiceModel::where('pi_id', '=', $id)->where('purchase_invoice.company_id', $auth->company_id)->first();

        $credit_purchase_invoice = CreditPurchaseInvoiceModel::where('credit_purchase_invoice.company_id', $auth->company_id)->get();

        return view('credit_purchase/add_credit_purchase', compact('credit_purchase_invoice', 'credit_purchase_invoice_detail', 'cash_accounts'))->with('pageTitle', 'Create Purchase Invoice');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_credit_purchase(Request $request)
    {
        $this->validate($request, [
            'invoice' => 'required',
            'cash_account' => 'required',
            'amount' => 'required|integer|min:0',
            'estimated_cost' => 'required|integer|min:1',
            'remaining_estimated_cost' => 'required|integer|min:0',
        ]);

        global $pi_id;
        DB::transaction(function () use ($request, $pi_id) {
            $auth = Auth::user();
            $credit_purchase_invoice = new CreditPurchaseInvoiceModel();
            $credit_purchase_invoice->cpi_pi_id = $request->invoice;
            $credit_purchase_invoice->cpi_cash_account = $request->cash_account;
            $credit_purchase_invoice->cpi_party_id = $request->party;
            $credit_purchase_invoice->cpi_amount_paid = $request->amount;
            $credit_purchase_invoice->cpi_real_estimated_cost = $request->real_estimated_cost;
            $credit_purchase_invoice->cpi_estimated_cost = $request->estimated_cost;
            $credit_purchase_invoice->cpi_remaining_cost = $request->remaining_estimated_cost;
            $credit_purchase_invoice->cpi_discount = $request->discount;
            $credit_purchase_invoice->cpi_remarks = $request->remarks;
            $credit_purchase_invoice->cpi_user_id = $auth->id;

            if ($request->remaining_estimated_cost == 0) {
                $credit_purchase_invoice->cpi_status = 'Paid';
            } else {
                $credit_purchase_invoice->cpi_status = 'Credit';
            }

            $t_amount_pay = $request->real_estimated_cost - $request->remaining_estimated_cost;

            // coding from shahzaib start
            $tbl_var_name = 'credit_purchase_invoice';
            $prfx = 'cpi';
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->get_ip();

            $brwsr_col = $prfx . '_browser_info';
            $ip_col = $prfx . '_ip_address';
            //            $updt_date_col = $prfx . '_updated_at';

            $$tbl_var_name->$brwsr_col = $brwsr_rslt;
            $$tbl_var_name->$ip_col = $clientIP;
            //            $$tbl_var_name->$updt_date_col = Carbon::now('GMT+5');
            // coding from shahzaib end

            $credit_purchase_invoice->save();

            if ($request->remaining_estimated_cost == 0) {
                //        update Purchase status
                PurchaseInvoiceModel::where('pi_id', '=', $request->invoice)->update(['pi_status' => 'Paid', 'pi_remaining' => $request->remaining_estimated_cost, 'pi_amount_pay' => $t_amount_pay]);
            } else {
                //        update Purchase status
                PurchaseInvoiceModel::where('pi_id', '=', $request->invoice)->update(['pi_status' => 'Credit', 'pi_remaining' => $request->remaining_estimated_cost, 'pi_amount_pay' => $t_amount_pay]);
            }

            //        update cash account
            $pat = CashAccountModel::where('ca_id', '=', $request->cash_account)->first();
            $pat->ca_balance = $pat->ca_balance - $request->amount;
            $pat->save();

            //        add cash book data
            $last_qty = CashBookModel::where('cb_ca_id', '=', $request->cash_account)
                ->OrderBy('cb_id', 'DESC')
                ->first();

            if ($last_qty == null) {
                $new_qty = $request->amount;
            } else {
                $new_qty = $last_qty->cb_total - $request->amount;
            }

            $cash_book = new CashBookModel();
            $cash_book->cb_ca_id = $credit_purchase_invoice->cpi_cash_account;
            $cash_book->cb_user_id = $auth->id;
            $cash_book->cb_type = 'Credit Purchase Invoice';
            $cash_book->cb_type_id = $credit_purchase_invoice->cpi_id;
            //            $cash_book->cb_job_id = $credit_purchase_invoice->cpi_id;
            //            $cash_book->cb_job_id = $request->job_no;
            $cash_book->cb_out = $request->amount;
            $cash_book->cb_total = $new_qty;
            $cash_book->save();

            global $pi_id;

            $pi_id = $credit_purchase_invoice->cpi_pi_id;
        });

        //        dd($cpi_id);

        return redirect()
            ->back()
            ->with('pi_id', $pi_id);
    }

    //purchase_invoice_modal
    public function credit_purchase_modal_view_details(Request $request)
    {
        $auth = Auth::user();
        $items = PurchaseInvoiceModel::where('pi_inv_id', $request->id)
            ->where('purchase_invoice.company_id', $auth->company_id)
            ->leftJoin('purchase_invoice_items', 'purchase_invoice.pi_inv_id', '=', 'purchase_invoice_items.pii_inv_id')
            ->where('purchase_invoice_items.company_id', $auth->company_id)
            ->leftJoin('credit_purchase_invoice', 'credit_purchase_invoice.cpi_inv_id', '=', 'purchase_invoice.pi_inv_id')
            ->where('credit_purchase_invoice.company_id', $auth->company_id)
            ->leftJoin('party', 'party.party_id', '=', 'purchase_invoice.pi_party_id')
            ->where('party.company_id', $auth->company_id)
            ->get();

        return response()->json($items);
    }

    public function credit_purchase_modal_view_details_SH(Request $request, $id)
    {
        //        $items = PurchaseInvoiceModel::where('pi_id', $request->id)
        //            ->leftJoin('purchase_invoice_items', 'purchase_invoice.pi_id','=', 'purchase_invoice_items.pii_pi_id')
        //            ->leftJoin('credit_purchase_invoice', 'credit_purchase_invoice.cpi_pi_id','=', 'purchase_invoice.pi_id')
        //            ->leftJoin('party', 'party.party_id','=', 'purchase_invoice.pi_party_id')
        //            ->get();
        $auth = Auth::user();
        $items = DB::table('purchase_invoice_items')
            ->where('purchase_invoice_items.company_id', $auth->company_id)
            ->leftJoin('parts', 'parts.par_id', '=', 'purchase_invoice_items.pii_part_name')
            ->where('parts.company_id', $auth->company_id)
            ->leftJoin('purchase_invoice', 'purchase_invoice.pi_inv_id', '=', 'purchase_invoice_items.pii_inv_id')
            ->where('purchase_invoice.company_id', $auth->company_id)
            ->leftJoin('party', 'party.party_id', '=', 'purchase_invoice.pi_party_id')
            ->where('party.company_id', $auth->company_id)
            ->where('pii_inv_id', $id)
            ->get();

        $credit_items = DB::table('credit_purchase_invoice')
            ->where('credit_purchase_invoice.company_id', $auth->company_id)
            //            ->leftJoin('parts', 'parts.par_id','=', 'credit_purchase_invoice.pii_part_name')
            ->leftJoin('purchase_invoice', 'purchase_invoice.pi_inv_id', '=', 'credit_purchase_invoice.cpi_inv_id')
            ->where('purchase_invoice.company_id', $auth->company_id)
            //            ->leftJoin('party', 'party.party_id','=', 'purchase_invoice.pi_party_id')
            ->where('cpi_inv_id', $id)
            ->get();
        $company_profile = CompanyProfile::where('company_id', $auth->company_id)->first();
        // dd($id, $items, $credit_items, $company_profile);
        //        return $items;

        $type = 'grid';
        $pge_title = 'Purchase Invoice';

        return view('credit_purchase/credit_purchase_modal', compact('company_profile', 'type', 'pge_title', 'items', 'credit_items'));
    }

    public function credit_purchase_modal_view_details_pdf_SH(Request $request, $id)
    {
        //        $items = PurchaseInvoiceModel::where('pi_id', $request->id)
        //            ->leftJoin('purchase_invoice_items', 'purchase_invoice.pi_id','=', 'purchase_invoice_items.pii_pi_id')
        //            ->leftJoin('credit_purchase_invoice', 'credit_purchase_invoice.cpi_pi_id','=', 'purchase_invoice.pi_id')
        //            ->leftJoin('party', 'party.party_id','=', 'purchase_invoice.pi_party_id')
        //            ->get();
        $auth = Auth::user();
        $items = DB::table('purchase_invoice_items')
            ->where('purchase_invoice_items.company_id', $auth->company_id)
            ->leftJoin('parts', 'parts.par_id', '=', 'purchase_invoice_items.pii_part_name')
            ->where('parts.company_id', $auth->company_id)
            ->leftJoin('purchase_invoice', 'purchase_invoice.pi_inv_id', '=', 'purchase_invoice_items.pii_inv_id')
            ->where('purchase_invoice.company_id', $auth->company_id)
            ->leftJoin('party', 'party.party_id', '=', 'purchase_invoice.pi_party_id')
            ->where('party.company_id', $auth->company_id)
            ->where('pii_inv_id', $id)
            ->get();

        $credit_items = DB::table('credit_purchase_invoice')
            ->where('credit_purchase_invoice.company_id', $auth->company_id)
            //            ->leftJoin('parts', 'parts.par_id','=', 'credit_purchase_invoice.pii_part_name')
            ->leftJoin('purchase_invoice', 'purchase_invoice.pi_inv_id', '=', 'credit_purchase_invoice.cpi_inv_id')
            ->where('purchase_invoice.company_id', $auth->company_id)
            //            ->leftJoin('party', 'party.party_id','=', 'purchase_invoice.pi_party_id')
            ->where('cpi_inv_id', $id)
            ->get();
        $company_profile = CompanyProfile::where('company_id', $auth->company_id)->first();
        $type = 'pdf';
        $pge_title = 'Purchase Invoice';

        //        $footer = view('invoice_view._partials.pdf_footer')->render();
        //        $header = view('invoice_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type'))->render();
        //        $options = [
        //            'footer-html' => $footer,
        //            'header-html' => $header,
        //            'margin-top' => 24,
        //        ];

        $pdf = PDF::loadView('credit_purchase/credit_purchase_modal_pdf', compact('company_profile', 'items', 'type', 'pge_title', 'credit_items'));
        //        $pdf->setOptions($options);

        return $pdf->stream('Purchase-Invoice-Detail.pdf');
    }
}
