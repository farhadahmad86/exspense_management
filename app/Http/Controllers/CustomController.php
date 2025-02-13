<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CashAccountModel;
use App\Models\Category;
use App\Models\CompanyProfile;
use App\Models\IssuePartsToJobItemsModel;
use App\Models\IssuePartsToJobModel;
use App\Models\JobInformationItemsModel;
use App\Models\JobInformationModel;
use App\Models\PartsModel;
use App\Models\PartyModel;
use App\Models\ProductsModel;
use App\Models\PurchaseInvoiceItemsModel;
use App\Models\PurchaseInvoiceModel;
use App\Models\SaleInvoiceForJobsModel;
use App\Models\SaleInvoiceItemsModel;
use App\Models\Technician;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use NumberFormatter;

class CustomController extends Controller
{
    public function getInvoiceData(Request $request)
    {
        $inv_id = $request->InvoiceID;
        $auth = Auth::user();
        // Fetch the purchase invoice data including the related items
        $invoice = PurchaseInvoiceModel::where('purchase_invoice.company_id', $auth->company_id)
            ->where('purchase_invoice.pi_id', $inv_id)
            ->leftjoin('purchase_invoice_items', 'purchase_invoice_items.pii_pi_id', '=', 'purchase_invoice.pi_id')
            ->get();
//            dd($invoice);
        // Return the data as JSON response
        return response()->json($invoice);
    }
    //products_issue_modal
    public function products_issue_modal_view_details(Request $request)
    {
        $auth = Auth::user();
        // dd(2);
        $items = IssuePartsToJobItemsModel::where('iptji_id', $request->id)
            ->where('company_id', $auth->company_id)
            ->where('iptji_status', 'issued')
            ->get();

        return response()->json($items);
    }

    public function products_issue_modal_view_details_SH(Request $request, $id)
    {
        // dd(2);
        $auth = Auth::user();
        $items = DB::table('issue_products_to_job_items')
            ->where('issue_products_to_job_items.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'issue_products_to_job_items.iptji_products')
            ->where('products.company_id', $auth->company_id)
            ->where('iptji_inv_id', $id)
            ->where('iptji_status', 'issued')
            ->get();

        //        return $items;

        $type = 'grid';
        $pge_title = 'Sale Invoice';

        return view('modal_views.products_issue_modal', compact('type', 'pge_title', 'items'));
    }
    public function products_issue_modal_view_details_pdf_SH(Request $request, $id)
    {
        // $sim = DB::table('financials_sale_invoice')
        //     ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_invoice.si_party_code')
        //     ->where('si_id', $id)
        //     ->select('financials_accounts.account_urdu_name as si_party_name', 'si_id', 'si_party_code', 'si_customer_name', 'si_remarks', 'si_total_items', 'si_total_price', 'si_product_disc', 'si_round_off_disc', 'si_cash_disc_per', 'si_cash_disc_amount', 'si_total_discount', 'si_inclusive_sales_tax', 'si_exclusive_sales_tax', 'si_total_sales_tax', 'si_grand_total', 'si_cash_received', 'si_day_end_id', 'si_day_end_date', 'si_createdby', 'si_sale_person', 'si_service_invoice_id', 'si_local_invoice_id', 'si_local_service_invoice_id', 'si_cash_received_from_customer', 'si_return_amount')
        //     ->first();

        // $type = 'pdf';
        // $pge_title = 'Sale Invoice';

        // $footer = view('invoice_view._partials.pdf_footer')->render();
        // $header = view('invoice_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type'))->render();
        // $options = [
        //     'footer-html' => $footer,
        //     'header-html' => $header,
        //     'margin-top' => 24,
        // ];

        // $pdf = PDF::loadView('invoice_view.sale_invoice.sale_invoice_list_modal', compact('siims', 'sim', 'seim', 'nbrOfWrds', 'accnts', 'type', 'pge_title', 'cash_received'));
        // $pdf->setOptions($options);

        // return $pdf->stream('Sale-Invoice.pdf');
    }
    public function products_return_modal_view_details(Request $request)
    {
        $auth = Auth::user();
        // dd(2);
        $items = IssuePartsToJobItemsModel::where('iptji_id', $request->id)
            ->where('company_id', $auth->company_id)
            ->where('iptji_status', 'returned')
            ->get();

        return response()->json($items);
    }

    public function products_return_modal_view_details_SH(Request $request, $id)
    {
        // dd(2);
        $auth = Auth::user();
        $items = DB::table('issue_products_to_job_items')
            ->where('issue_products_to_job_items.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'issue_products_to_job_items.iptji_products')
            ->where('products.company_id', $auth->company_id)
            ->where('iptji_inv_id', $id)
            ->where('iptji_status', 'returned')
            ->get();

        //        return $items;

        $type = 'grid';
        $pge_title = 'Sale Invoice';

        return view('modal_views.products_issue_modal', compact('type', 'pge_title', 'items'));
    }
    public function products_return_modal_view_details_pdf_SH(Request $request, $id)
    {
        // $sim = DB::table('financials_sale_invoice')
        //     ->join('financials_accounts', 'financials_accounts.account_uid', '=', 'financials_sale_invoice.si_party_code')
        //     ->where('si_id', $id)
        //     ->select('financials_accounts.account_urdu_name as si_party_name', 'si_id', 'si_party_code', 'si_customer_name', 'si_remarks', 'si_total_items', 'si_total_price', 'si_product_disc', 'si_round_off_disc', 'si_cash_disc_per', 'si_cash_disc_amount', 'si_total_discount', 'si_inclusive_sales_tax', 'si_exclusive_sales_tax', 'si_total_sales_tax', 'si_grand_total', 'si_cash_received', 'si_day_end_id', 'si_day_end_date', 'si_createdby', 'si_sale_person', 'si_service_invoice_id', 'si_local_invoice_id', 'si_local_service_invoice_id', 'si_cash_received_from_customer', 'si_return_amount')
        //     ->first();

        // $type = 'pdf';
        // $pge_title = 'Sale Invoice';

        // $footer = view('invoice_view._partials.pdf_footer')->render();
        // $header = view('invoice_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type'))->render();
        // $options = [
        //     'footer-html' => $footer,
        //     'header-html' => $header,
        //     'margin-top' => 24,
        // ];

        // $pdf = PDF::loadView('invoice_view.sale_invoice.sale_invoice_list_modal', compact('siims', 'sim', 'seim', 'nbrOfWrds', 'accnts', 'type', 'pge_title', 'cash_received'));
        // $pdf->setOptions($options);

        // return $pdf->stream('Sale-Invoice.pdf');
    }
    public function product_loss_modal_view_details_SH(Request $request, $id)
    {
        $auth = Auth::user();
        // dd(2);
        // $items = IssuePartsToJobItemsModel::where('iptji_iptj_id', $id)->get();

        $items = DB::table('product_loss')
            ->where('product_loss.company_id', $auth->company_id)
            ->leftJoin('users', 'users.id', '=', 'product_loss.pl_user_id')
            ->where('users.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'product_loss.pl_part_id')
            ->where('products.company_id', $auth->company_id)
            ->where('pl_inv_id', $id)
            ->get();

        //        return $items;

        $type = 'grid';
        $pge_title = 'Sale Invoice';

        return view('modal_views.product_loss_modal', compact('type', 'pge_title', 'items'));
    }
    public function part_recover_modal_view_details_SH(Request $request, $id)
    {
        $auth = Auth::user();
        // dd(2);
        // $items = IssuePartsToJobItemsModel::where('iptji_iptj_id', $id)->get();

        $items = DB::table('product_recover')
            ->where('product_recover.company_id', $auth->company_id)
            ->leftJoin('users', 'users.id', '=', 'product_recover.pr_user_id')
            ->where('users.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'product_recover.pr_part_id')
            ->where('products.company_id', $auth->company_id)
            ->where('pr_inv_id', $id)
            ->get();

        //        return $items;

        $type = 'grid';
        $pge_title = 'Sale Invoice';

        return view('modal_views.product_recover_modal', compact('type', 'pge_title', 'items'));
    }
    public function part_return_modal_view_details_SH(Request $request, $id)
    {
        $auth = Auth::user();
        // dd(2);
        // $items = IssuePartsToJobItemsModel::where('iptji_iptj_id', $id)->get();

        $items = DB::table('issue_products_to_job')
            ->where('issue_products_to_job.company_id', $auth->company_id)
            ->leftJoin('job_information', 'job_information.job_id', '=', 'issue_products_to_job.iptj_job_no')
            ->where('job_information.company_id', $auth->company_id)
            ->leftJoin('job_issue_to_technician', 'job_issue_to_technician.jitt_job_no', '=', 'job_information.job_id')
            ->where('job_issue_to_technician.company_id', $auth->company_id)
            ->leftJoin('technician', 'technician.tech_id', '=', 'job_issue_to_technician.jitt_technician')
            ->where('technician.company_id', $auth->company_id)
            ->leftJoin('issue_products_to_job_items', 'issue_products_to_job_items.iptji_iptj_id', '=', 'issue_products_to_job.iptj_id')
            ->where('issue_products_to_job_items.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'issue_products_to_job_items.iptji_products')
            ->where('products.company_id', $auth->company_id)
            ->where('iptj_status', 'Returned')
            ->where('iptj_inv_id', $id)
            // ->where('iptji_iptj_id', $id)
            ->get();

        //        return $items;

        $type = 'grid';
        $pge_title = 'Part Return';

        return view('modal_views.part_return_modal', compact('type', 'pge_title', 'items'));
    }
    public function part_issue_modal_view_details_SH(Request $request, $id)
    {
        // dd(2);
        $items = IssuePartsToJobItemsModel::where('iptji_iptj_id', $id)->get();
        $auth = Auth::user();
        $items = DB::table('issue_products_to_job')
            ->where('issue_products_to_job.company_id', $auth->company_id)
            ->leftJoin('job_information', 'job_information.job_id', '=', 'issue_products_to_job.iptj_job_no')
            ->where('job_information.company_id', $auth->company_id)
            ->leftJoin('job_issue_to_technician', 'job_issue_to_technician.jitt_job_no', '=', 'job_information.job_id')
            ->where('job_issue_to_technician.company_id', $auth->company_id)
            ->leftJoin('technician', 'technician.tech_id', '=', 'job_issue_to_technician.jitt_technician')
            ->where('technician.company_id', $auth->company_id)
            ->leftJoin('issue_products_to_job_items', 'issue_products_to_job_items.iptji_iptj_id', '=', 'issue_products_to_job.iptj_id')
            ->where('issue_products_to_job_items.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'issue_products_to_job_items.iptji_products')
            ->where('products.company_id', $auth->company_id)
            ->where('iptj_status', 'Issued')
            ->where('iptj_inv_id', $id)
            // ->where('iptji_iptj_id', $id)
            ->get();

        //        return $items;

        $type = 'grid';
        $pge_title = 'Part Return';

        return view('modal_views.part_issue_modal', compact('type', 'pge_title', 'items'));
    }
    public function estimate_history(Request $request, $id)
    {
        $auth = Auth::user();
        $items = DB::table('estimate_versions')
            ->where('estimate_versions.company_id', $auth->company_id)
            ->where('ev_job_no', $id)
            ->get();
        // dd($items);
        //    return $items;

        $type = 'grid';
        $pge_title = 'Sale Invoice';

        return view('modal_views.estimate_charges', compact('type', 'pge_title', 'items'));
    }

    //sale_job_invoice_modal
    public function sale_job_invoice_modal_view_details(Request $request)
    {
        $auth = Auth::user();
        $items = SaleInvoiceForJobsModel::where('sifj_inv_id', $request->id)
            ->where('sale_invoice_for_jobs.company_id', $auth->company_id)
            ->leftJoin('job_information', 'job_information.job_id', '=', 'sale_invoice_for_jobs.sifj_job_no')
            ->where('job_information.company_id', $auth->company_id)
            ->get();

        return response()->json($items);
    }

    //PDF me Load hony sy pehly
    public function sale_job_invoice_modal_view_details_SH(Request $request, $id)
    {
        //    dd(12);
        $auth = Auth::user();
        $items = DB::table('sale_invoice_for_jobs')
            ->where('sale_invoice_for_jobs.company_id', $auth->company_id)
            ->leftJoin('job_information', 'job_information.job_id', '=', 'sale_invoice_for_jobs.sifj_job_no')
            ->where('job_information.company_id', $auth->company_id)
            ->leftJoin('brands', 'brands.bra_id', '=', 'job_information.ji_bra_id')
            ->where('brands.company_id', $auth->company_id)
            ->leftJoin('categories', 'categories.cat_id', '=', 'job_information.ji_cat_id')
            ->where('categories.company_id', $auth->company_id)
            ->leftJoin('model_table', 'model_table.mod_id', '=', 'job_information.ji_mod_id')
            ->where('model_table.company_id', $auth->company_id)
            ->leftJoin('client', 'client.cli_id', '=', 'job_information.ji_cli_id')
            ->where('client.company_id', $auth->company_id)
            ->where('sifj_inv_id', $id)
            ->get();

        //        return $items;

        $complain_items = DB::table('job_information_items')
            ->select(DB::raw("jii_ji_job_id, GROUP_CONCAT(jii_item_name,'') jii_item_name"))
            ->where('jii_status', '=', 'Complain')
            ->where('company_id', $auth->company_id)
            ->groupBy('jii_ji_job_id')
            ->get();

        $accessory_items = DB::table('job_information_items')
            ->select(DB::raw("jii_ji_job_id, GROUP_CONCAT(jii_item_name,'') jii_item_name"))
            ->where('jii_status', '=', 'Accessory')
            ->where('company_id', $auth->company_id)
            ->groupBy('jii_ji_job_id')
            ->get();
        $company_profile = CompanyProfile::where('company_id', $auth->company_id)->first();
        // dd(1);
        $type = 'grid';
        $pge_title = 'Job Sale Invoice';

        return view('modal_views.job_sale_invoice_modal', compact('company_profile', 'type', 'pge_title', 'items', 'complain_items', 'accessory_items'));
    }

    //PDF me ye code chal rha h
    public function sale_job_invoice_modal_view_details_pdf_SH(Request $request, $id)
    {
        $auth = Auth::user();
        $items = DB::table('sale_invoice_for_jobs')
            ->where('sale_invoice_for_jobs.company_id', $auth->company_id)
            ->leftJoin('job_information', 'job_information.job_id', '=', 'sale_invoice_for_jobs.sifj_job_no')
            ->where('job_information.company_id', $auth->company_id)
            ->leftJoin('brands', 'brands.bra_id', '=', 'job_information.ji_bra_id')
            ->where('brands.company_id', $auth->company_id)
            ->leftJoin('categories', 'categories.cat_id', '=', 'job_information.ji_cat_id')
            ->where('categories.company_id', $auth->company_id)
            ->leftJoin('model_table', 'model_table.mod_id', '=', 'job_information.ji_mod_id')
            ->where('model_table.company_id', $auth->company_id)
            ->leftJoin('client', 'client.cli_id', '=', 'job_information.ji_cli_id')
            ->where('client.company_id', $auth->company_id)
            ->where('sifj_inv_id', $id)
            ->get();

        //        return $items;

        $complain_items = DB::table('job_information_items')
            ->select(DB::raw("jii_ji_job_id, GROUP_CONCAT(jii_item_name,'') jii_item_name"))
            ->where('jii_status', '=', 'Complain')
            ->where('company_id', $auth->company_id)
            ->groupBy('jii_ji_job_id')
            ->get();

        $accessory_items = DB::table('job_information_items')
            ->select(DB::raw("jii_ji_job_id, GROUP_CONCAT(jii_item_name,'') jii_item_name"))
            ->where('jii_status', '=', 'Accessory')
            ->where('company_id', $auth->company_id)
            ->groupBy('jii_ji_job_id')
            ->get();
        $company_profile = CompanyProfile::where('company_id', $auth->company_id)->first();
        // dd($items);
        $type = 'pdf';
        $pge_title = 'Job Sale Invoice';

        //        $footer = view('invoice_view._partials.pdf_footer')->render();
        //        $header = view('invoice_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type'))->render();
        //        $options = [
        //            'footer-html' => $footer,
        //            'header-html' => $header,
        //            'margin-top' => 24,
        //        ];

        //        $pdf = SnappyPdf::loadView('modal_views.job_sale_invoice_modal', compact( 'items',    'type', 'pge_title','complain_items','accessory_items'));
        $pdf = PDF::loadView('modal_views.pdf_sale_invoice', compact('company_profile', 'items', 'type', 'pge_title', 'complain_items', 'accessory_items'));
        //        $pdf->setOptions($options);

        return $pdf->stream('Job-Sale-Invoice.pdf');
    }

    //sale_invoice_modal
    public function sale_invoice_modal_view_details(Request $request)
    {
        $auth = Auth::user();
        $items = SaleInvoiceItemsModel::where('sii_inv_id', $request->id)
            ->where('sale_invoice_items.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'sale_invoice_items.sii_part_name')
            ->where('products.company_id', $auth->company_id)
            ->leftJoin('sale_invoice', 'sale_invoice.si_inv_id', '=', 'sale_invoice_items.sii_si_id')
            ->where('sale_invoice.company_id', $auth->company_id)
            ->get();

        return response()->json($items);
    }

    public function sale_invoice_modal_view_details_SH(Request $request, $id)
    {
        // $items = SaleInvoiceItemsModel::where('sii_si_id', $id)->get();
        $auth = Auth::user();
        $items = DB::table('sale_invoice_items')
            ->where('sale_invoice_items.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'sale_invoice_items.sii_part_name')
            ->where('products.company_id', $auth->company_id)
            ->leftJoin('sale_invoice', 'sale_invoice.si_inv_id', '=', 'sale_invoice_items.sii_inv_id')
            ->where('sale_invoice.company_id', $auth->company_id)
            ->leftJoin('party', 'party.party_id', '=', 'sale_invoice.si_party_id')
            ->where('party.company_id', $auth->company_id)
            ->where('si_id', $id)
            ->get();
        $company_profile = CompanyProfile::where('company_id', $auth->company_id)->first();
        //        return $items;
        // dd($id,$items);

        $type = 'grid';
        $pge_title = 'Sale Invoice';
//dd($items);
        return view('modal_views.sale_invoice_modal', compact('company_profile', 'type', 'pge_title', 'items'));
    }

    public function sale_invoice_modal_view_details_pdf_SH(Request $request, $id)
    {
        $auth = Auth::user();
        $items = DB::table('sale_invoice_items')
            ->where('sale_invoice_items.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'sale_invoice_items.sii_part_name')
            ->where('products.company_id', $auth->company_id)
            ->leftJoin('sale_invoice', 'sale_invoice.si_inv_id', '=', 'sale_invoice_items.sii_inv_id')
            ->where('sale_invoice.company_id', $auth->company_id)
            ->leftJoin('party', 'party.party_id', '=', 'sale_invoice.si_party_id')
            ->where('party.company_id', $auth->company_id)
            ->where('sii_inv_id', $id)
            ->get();
        $company_profile = CompanyProfile::where('company_id', $auth->company_id)->first();
        $type = 'pdf';
        $pge_title = 'Sale Invoice';

        //        $footer = view('invoice_view._partials.pdf_footer')->render();
        //        $header = view('invoice_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type'))->render();
        //        $options = [
        //            'footer-html' => $footer,
        //            'header-html' => $header,
        //            'margin-top' => 24,
        //        ];

        $pdf = PDF::loadView('modal_views.pdf_sale_invoice_modal', compact('company_profile', 'items', 'type', 'pge_title'));
        //        $pdf->setOptions($options);

        return $pdf->stream('Purchase-Invoice.pdf');
    }

    //purchase_invoice_modal
    public function purchase_invoice_modal_view_details(Request $request)
    {
        // dd(1);
        $auth = Auth::user();
        $items = PurchaseInvoiceItemsModel::where('pii_inv_id', $request->id)
            ->where('purchase_invoice_items.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'purchase_invoice_items.pii_part_name')
            ->where('products.company_id', $auth->company_id)
            ->leftJoin('purchase_invoice', 'purchase_invoice.pi_inv_id', '=', 'purchase_invoice_items.pii_pi_id')
            ->where('purchase_invoice.company_id', $auth->company_id)
            ->get();

        return response()->json($items);
    }

    public function purchase_invoice_modal_view_details_SH(Request $request, $id)
    {
        // dd(1);
        // $items = PurchaseInvoiceItemsModel::where('pii_pi_id', $id)->get();
        $auth = Auth::user();
        $items = DB::table('purchase_invoice_items')
            ->where('purchase_invoice_items.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'purchase_invoice_items.pii_part_name')
            ->where('products.company_id', $auth->company_id)
            ->leftJoin('purchase_invoice', 'purchase_invoice.pi_inv_id', '=', 'purchase_invoice_items.pii_inv_id')
            ->where('purchase_invoice.company_id', $auth->company_id)
            ->leftJoin('party', 'party.party_id', '=', 'purchase_invoice.pi_party_id')
            ->where('party.company_id', $auth->company_id)

            ->where('pii_inv_id', $id)
            ->get();
        $company_profile = CompanyProfile::where('company_id', $auth->company_id)->first();
        // dd($items, $company_profile);
        //        return $items;

        $type = 'grid';
        $pge_title = 'Purchase Invoice';

        return view('modal_views.purchase_invoice_modal', compact('company_profile', 'type', 'pge_title', 'items'));
    }

    public function purchase_invoice_modal_view_details_pdf_SH(Request $request, $id)
    {
        $auth = Auth::user();
        $items = DB::table('purchase_invoice_items')
            ->where('purchase_invoice_items.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'purchase_invoice_items.pii_part_name')
            ->where('products.company_id', $auth->company_id)
            ->leftJoin('purchase_invoice', 'purchase_invoice.pi_inv_id', '=', 'purchase_invoice_items.pii_inv_id')
            ->where('purchase_invoice.company_id', $auth->company_id)
            ->leftJoin('party', 'party.party_id', '=', 'purchase_invoice.pi_party_id')
            ->where('party.company_id', $auth->company_id)

            ->where('pii_inv_id', $id)
            ->get();
        $company_profile = CompanyProfile::where('company_id', $auth->company_id)->first();
        $type = 'pdf';
        $pge_title = 'Purchase Invoice';

        //        $footer = view('invoice_view._partials.pdf_footer')->render();
        //        $header = view('invoice_view._partials.pdf_header', compact( 'pge_title', 'type'))->render();
        //        $options = [
        //            'footer-html' => $footer,
        //            'header-html' => $header,
        //            'margin-top' => 24,
        //        ];

        $pdf = PDF::loadView('modal_views.pdf_purchase_invoice_modal', compact('company_profile', 'items', 'type', 'pge_title'));
        //        $pdf->setOptions($options);

        return $pdf->stream('Purchase-Invoice.pdf');
    }

    //Job Information modal
    // public function job_info_modal_view_details(Request $request)
    // {
    //     // dd(1);
    //     $items = JobInformationModel::where('ji_id', $request->id)
    //         ->leftJoin('job_information_items', 'job_information_items.jii_ji_job_id', '=', 'job_information.ji_id')
    //         ->get();

    //     return response()->json($items);
    // }

    // //PDF me Load hony sy pehly
    // public function job_info_modal_view_details_SH(Request $request, $id)
    // {
    //     //    dd(12);
    //     $items = DB::table('job_information')
    //         ->leftJoin('brands', 'brands.bra_id', '=', 'job_information.ji_bra_id')
    //         ->leftJoin('categories', 'categories.cat_id', '=', 'job_information.ji_cat_id')
    //         ->leftJoin('model_table', 'model_table.mod_id', '=', 'job_information.ji_mod_id')
    //         ->leftJoin('client', 'client.cli_id', '=', 'job_information.ji_cli_id')
    //         ->where('ji_id', $id)
    //         ->get();

    //     //        return $items;

    //     $complain_items = DB::table('job_information_items')
    //         ->select(DB::raw("jii_ji_job_id, GROUP_CONCAT(jii_item_name,'') jii_item_name"))
    //         ->where('jii_status', '=', 'Complain')
    //         ->groupBy('jii_ji_job_id')
    //         ->get();

    //     $accessory_items = DB::table('job_information_items')
    //         ->select(DB::raw("jii_ji_job_id, GROUP_CONCAT(jii_item_name,'') jii_item_name"))
    //         ->where('jii_status', '=', 'Accessory')
    //         ->groupBy('jii_ji_job_id')
    //         ->get();

    //     $type = 'grid';
    //     $pge_title = 'Job Information Invoice';

    //     return view('modal_views.job_info_modal', compact('type', 'pge_title', 'items', 'complain_items', 'accessory_items'));
    // }

    // //PDF me ye code chal rha h
    // public function job_info_modal_view_details_pdf_SH(Request $request, $id)
    // {
    //     //    dd(2);
    //     $items = DB::table('job_information')
    //         ->leftJoin('brands', 'brands.bra_id', '=', 'job_information.ji_bra_id')
    //         ->leftJoin('categories', 'categories.cat_id', '=', 'job_information.ji_cat_id')
    //         ->leftJoin('model_table', 'model_table.mod_id', '=', 'job_information.ji_mod_id')
    //         ->leftJoin('client', 'client.cli_id', '=', 'job_information.ji_cli_id')
    //         ->where('ji_id', $id)
    //         ->get();

    //     $complain_items = DB::table('job_information_items')
    //         ->select(DB::raw("jii_ji_job_id, GROUP_CONCAT(jii_item_name,'') jii_item_name"))
    //         ->where('jii_status', '=', 'Complain')
    //         ->groupBy('jii_ji_job_id')
    //         ->get();

    //     $accessory_items = DB::table('job_information_items')
    //         ->select(DB::raw("jii_ji_job_id, GROUP_CONCAT(jii_item_name,'') jii_item_name"))
    //         ->where('jii_status', '=', 'Accessory')
    //         ->groupBy('jii_ji_job_id')
    //         ->get();

    //     $type = 'pdf';
    //     $pge_title = 'Job Information Invoice';

    //     //        $footer = view('invoice_view._partials.pdf_footer')->render();
    //     //        $header = view('invoice_view._partials.pdf_header', compact('invoice_nbr', 'invoice_date', 'pge_title', 'type'))->render();
    //     //        $options = [
    //     //            'footer-html' => $footer,
    //     //            'header-html' => $header,
    //     //            'margin-top' => 24,
    //     //        ];

    //     //        $pdf = SnappyPdf::loadView('modal_views.job_sale_invoice_modal', compact( 'items',    'type', 'pge_title','complain_items','accessory_items'));
    //     $pdf = PDF::loadView('modal_views.pdf_job_info_modal', compact('items', 'type', 'pge_title', 'complain_items', 'accessory_items'));
    //     //        $pdf->setOptions($options);

    //     return $pdf->stream('Job-Information-Invoice.pdf');
    // }

    //    for ajax

    public function get_estimate(Request $request)
    {
        $auth = Auth::user();
        $bra_name_id = $request->bra_name_id;

        $cats = JobInformationModel::select('ji_estimated_cost')
            ->where('job_id', $bra_name_id)
            ->where('company_id', $auth->company_id)
            ->get();

        return response()->json($cats);
    }

    public function get_rate(Request $request)
    {
        $auth = Auth::user();
        $bra_name_id = $request->bra_name_id;

        $cats = PartsModel::where('par_id', $bra_name_id)
            ->where('company_id', $auth->company_id)
            ->get();

        return response()->json($cats);
    }

    public function get_estimate_for_sale(Request $request)
    {
        // dd($request->job_id);
        $job_id = $request->job_id;
        $auth = Auth::user();
        $cats = DB::table('job_information')
            ->where('job_information.company_id', $auth->company_id)
            ->leftJoin('vendor', function ($join) use ($auth) {
                $join->on('vendor.vendor_id', '=', 'job_information.ji_vendor')->where('vendor.company_id', '=', $auth->company_id);
            })
            ->where('job_id', $job_id)
            ->get();

        // dd($cats);
        //        $cats = JobInformationModel::where('ji_id', $job_id)->get();
        return response()->json($cats);
    }

    public function get_stock_qty(Request $request)
    {
        $auth = Auth::user();
        $part_id = $request->part_id;

        $cats = PartsModel::select('par_total_qty')
            ->where('company_id', $auth->company_id)
            ->where('par_id', $part_id)
            ->get();

        return response()->json($cats);
    }

    public function get_data_job_info(Request $request)
    {
        $auth = Auth::user();
        $job_id = $request->job_id;
        $data = JobInformationItemsModel::where('jii_ji_job_id', $job_id)
            ->where('company_id', $auth->company_id)
            ->get();
//dd($data,$job_id);
        //        $complain = $data->where('jii_status','=','Accessory')->get();

        return response()->json($data);
    }

    public function get_account_total(Request $request)
    {
        $auth = Auth::user();
        $account_id = $request->account_id;

        //        dd($request->account_id);

        $data = CashAccountModel::where('ca_id', $account_id)
            ->where('company_id', $auth->company_id)
            ->get();

        //        $complain = $data->where('jii_status','=','Accessory')->get();

        return response()->json($data);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////     Json Product     //////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////
    public function get_technision(Request $request)
    {
        $auth = Auth::user();
        $products = JobInformationModel::where('ji_job_status', '=', 'Pending')
            ->where('company_id', $auth->company_id)
            ->get();

        //        $products = Technician::where("status",'=','1')->where("tech_status",'=','1')->get();
        return json_encode($products);

        $products = json_encode($products);

        return response()->json(json_encode($products));
    }

    public function get_brand(Request $request)
    {
        $auth = Auth::user();
        $brands = Brand::where('company_id', $auth->company_id)->get();

        //        $products = Technician::where("status",'=','1')->where("tech_status",'=','1')->get();
        return json_encode($brands);

        $brands = json_encode($brands);

        return response()->json(json_encode($brands));
    }

    //    public function get_category(Request $request)
    //    {
    //        $categories = Category::all();
    //
    ////        $products = Technician::where("status",'=','1')->where("tech_status",'=','1')->get();
    //        return json_encode($categories);
    //
    //        $categories = json_encode($categories);
    //
    //        return response()->json(json_encode($categories));
    //    }

    //PDF me Load hony sy pehly
    public function job_info_thermal_modal_view_details_SH($id)
    {
        $auth = Auth::user();
        $company_profile = CompanyProfile::where('company_id', $auth->company_id)->first();

        //    dd(12);
        $items = DB::table('job_information')
            ->where('job_information.company_id', $auth->company_id)
            ->leftJoin('brands', 'brands.bra_id', '=', 'job_information.ji_bra_id')
            ->where('brands.company_id', $auth->company_id)
            ->leftJoin('categories', 'categories.cat_id', '=', 'job_information.ji_cat_id')
            ->where('categories.company_id', $auth->company_id)
            ->leftJoin('model_table', 'model_table.mod_id', '=', 'job_information.ji_mod_id')
            ->where('model_table.company_id', $auth->company_id)
            ->leftJoin('client', 'client.cli_id', '=', 'job_information.ji_cli_id')
            ->where('client.company_id', $auth->company_id)
            ->where('job_id', $id)
            ->first();
        //        return $items;
        $nbrOfWrds = $this->myCnvrtNbr($items->ji_estimated_cost);

        $complain_items = DB::table('job_information_items')
            //  ->select(DB::raw("jii_ji_job_id, GROUP_CONCAT(jii_item_name,'') jii_item_name"))
            ->where('jii_status', '=', 'Complain')
            ->where('job_information_items.company_id', $auth->company_id)
            ->where('jii_ji_job_id', '=', $id)
            //  ->groupBy('jii_ji_job_id')
            ->get();

        $accessory_items = DB::table('job_information_items')
            //  ->select(DB::raw("jii_ji_job_id, GROUP_CONCAT(jii_item_name,'') jii_item_name"))
            ->where('jii_status', '=', 'Accessory')
            ->where('job_information_items.company_id', $auth->company_id)
            ->where('jii_ji_job_id', '=', $id)
            //  ->groupBy('jii_ji_job_id')
            ->get();

        return response()->json(['company_profile' => $company_profile, 'items' => $items, 'complain_items' => $complain_items, 'accessory_items' => $accessory_items, 'nbrOfWrds' => $nbrOfWrds]);
        $type = 'grid';
        $pge_title = 'Job Information Invoice';

        return view('modal_views.thermal_print_modal', compact('type', 'pge_title', 'items', 'complain_items', 'accessory_items'));
    }
    public function cash_payment_modal_view_details_SH($id)
    {
        // dd($id);
        $auth = Auth::user();

        //    dd(12);
        $datas = DB::table('cash_payment_voucher')
            ->where('cash_payment_voucher.company_id', $auth->company_id)
            ->leftJoin('users', 'users.id', '=', 'cash_payment_voucher.jpv_user_id')
            ->where('users.company_id', $auth->company_id)
            ->leftJoin('cash_account', 'cash_account.ca_id', '=', 'cash_payment_voucher.jpv_cash_account')
            ->where('cash_account.company_id', $auth->company_id)
            ->where('jpv_inv_id', $id)
            ->get();
        //        return $items;
        // dd($datas);
        return view('modal_views.cash_payment_voucher_modal', compact('datas'));
    }
    public function cash_receipt_modal_view_details_SH($id)
    {
        // dd($id);
        $auth = Auth::user();

        // dd(12);
        $datas = DB::table('cash_receipt_voucher')
            ->where('cash_receipt_voucher.company_id', $auth->company_id)
            ->leftJoin('users', 'users.id', '=', 'cash_receipt_voucher.jrv_user_id')
            ->where('users.company_id', $auth->company_id)
            ->leftJoin('cash_account', 'cash_account.ca_id', '=', 'cash_receipt_voucher.jrv_cash_account')
            ->where('cash_account.company_id', $auth->company_id)
            ->where('jrv_inv_id', $id)
            ->get();
        //        return $items;
        // dd($datas);
        return view('modal_views.cash_receipt_voucher_modal', compact('datas'));
    }
    public function refreshData()
    {
        $auth = Auth::user();
        $party = PartyModel::where('company_id', $auth->company_id)->get();
        $cash = CashAccountModel::where('company_id', $auth->company_id)->get();
        $parts = ProductsModel::where('par_status', '=', 'Opening')
            ->where('company_id', $auth->company_id)
            ->get();

        // Return data as JSON
        return response()->json([
            'cash' => $cash,
            'party' => $party,
            'parts' => $parts
        ]);
    }
}
