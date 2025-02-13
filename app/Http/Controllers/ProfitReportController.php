<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\select;

class ProfitReportController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:profit-report', ['only' => ['index', 'show']]);
    }
    public function index(Request $request)
    {
        $ar = json_decode($request->array);
        $pagination_number = empty($ar) ? 30 : 100000000;
        $auth = Auth::user();
        $datas = DB::table('sale_invoice')
            ->where('sale_invoice.company_id', $auth->company_id)
            ->leftJoin('sale_invoice_items', 'sale_invoice_items.sii_si_id', '=', 'sale_invoice.si_id')
            ->where('sale_invoice_items.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'sale_invoice_items.sii_part_name')
            ->where('products.company_id', $auth->company_id)
            ->where('si_status', 'Paid')
            ->select('sale_invoice.*', 'sale_invoice_items.*','products.par_id','products.par_name as product_name','products.par_purchase_price as product_purchase')
        ;
//            ->get();
        $query = $datas;
        $products = $request->product;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $start = date('Y-m-d', strtotime($from_date));
        $end = date('Y-m-d', strtotime($to_date));
        if (isset($request->product)) {
            $query->where('products.par_id', '=', $request->product);
        }
        if (!empty($request->from_date) && !empty($request->to_date)) {
            $query->whereDate('sale_invoice.si_created_at', '>=', $start)->whereDate('sale_invoice.si_created_at', '<=', $end);
            //            dd($query->get());
        } elseif (isset($request->from_date)) {
            $query->whereDate('sale_invoice.si_created_at', '=', $start);
        } elseif (isset($request->to_date)) {
            $query->whereDate('sale_invoice.si_created_at', '=', $end);
        }
        $product_title = DB::table('products')
            ->where('products.company_id', $auth->company_id)->get();
        $query = $query->orderBy('si_id', 'DESC')->paginate($pagination_number);
        return view('reports/profit_report', compact('product_title', 'products','from_date', 'to_date', 'query'))->with('pageTitle', 'Profit Report');
    }
}
