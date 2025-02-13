<?php

namespace App\Http\Controllers;

use App\Models\PartsModel;
use App\Models\ProductsModel;
use App\Models\StockModel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Sabberworm\CSS\Property\Selector;

class OpeningStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:stock-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:stock-report', ['only' => ['stock_smmary_report', 'show']]);
    }

    public function index(Request $request)
    {
        $auth = Auth::user();
        $ar = json_decode($request->array);
        $pagination_number = empty($ar) ? 30 : 100000000;
        // dd($ar,$pagination_number);
        $datas = DB::table('stock')
            ->whereNotIn('sto_type', ['Created'])
            ->where('stock.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'stock.sto_par_id')
            ->where('products.company_id', $auth->company_id);
        // Pluck sto_job_id values
        $stoJobIds = $datas->pluck('sto_job_id')->toArray();

        // Filter non-null values
        $nonNullJobIds = array_filter($stoJobIds, function ($value) {
            return $value !== null;
        });

        // dd($datas, $nonNullJobIds, $tech_name);
        $from_date = $request->from_date;
        $part_name = $request->part_name;
        $to_date = $request->to_date;
        $status = $request->status;
        $start = date('Y-m-d', strtotime($from_date));

        $end = date('Y-m-d', strtotime($to_date));
        $query = $datas;

        // Apply filters
        if (isset($request->part_name)) {
            $query->where('stock.sto_par_id', '=', $request->part_name);
        }
        if (isset($request->status)) {
            $query->where('stock.sto_type', 'like', '%' . $request->status . '%');
        }

        if (!empty($from_date) && !empty($to_date)) {
            $query->whereDate('stock.sto_created_at', '>=', $start)->whereDate('stock.sto_created_at', '<=', $end);
        } elseif (isset($request->from_date)) {
            $query->whereDate('stock.sto_created_at', '=', $start);
        } elseif (isset($request->to_date)) {
            $query->whereDate('stock.sto_created_at', '=', $end);
        }

        $parts_title = ProductsModel::whereIn('par_status', ['Opening', 'Created'])
            ->where('company_id', $auth->company_id)
            ->get();

        // $query = $query->get();
        // $query = $query->toSql();
        // dd($query);
        $query = $query->orderBy('sto_id', 'DESC')->paginate($pagination_number);

        return view('opening_stock/stock_list', compact('status', 'parts_title', 'from_date', 'to_date', 'query', 'part_name'))->with('pageTitle', 'Stock Movement List');
    }

    public function stock_smmary_report(Request $request)
    {
        $auth = Auth::user();
        $ar = json_decode($request->array);
        $pagination_number = empty($ar) ? 30 : 100000000;
        $latestRecords = DB::table('stock')
            ->select('sto_par_id', DB::raw('MAX(sto_id) as max_sto_id'))
            ->groupBy('sto_par_id');

        $datas = DB::table('stock')
            ->where('stock.company_id', $auth->company_id)
            ->leftJoin('products', 'products.par_id', '=', 'stock.sto_par_id')
            ->where('products.company_id', $auth->company_id)
            ->joinSub($latestRecords, 'latest_records', function ($join) {
                $join->on('stock.sto_par_id', '=', 'latest_records.sto_par_id')->on('stock.sto_id', '=', 'latest_records.max_sto_id');
            })
            ->where('stock.sto_total', '>', 0) // Add this condition to exclude rows where sto_total = 0
            ->select('stock.sto_par_id', 'stock.sto_id', 'stock.sto_total', 'stock.sto_in_rate', 'stock.sto_created_at', 'products.par_id', 'products.par_purchase_price', 'products.par_name');
        // ->get();

        // dd($datas);

        $job_no = $request->job_no;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $part_name = $request->part_name;
        $start = date('Y-m-d', strtotime($from_date));

        $end = date('Y-m-d', strtotime($to_date));
        $query = $datas;
        $prnt_page_dir = 'modal_views.stock_report';
        $pge_title = 'Job Information Report';

        if (isset($request->job_no)) {
            $query->orWhere('stock.sto_job_id', 'like', '%' . $request->job_no . '%');
        }
        if (isset($request->part_name)) {
            $query->where('stock.sto_par_id', '=', $request->part_name);
        }

        if (!empty($from_date) && !empty($to_date)) {
            $query->whereDate('stock.sto_created_at', '>=', $start)->whereDate('stock.sto_created_at', '<=', $end);
        } elseif (isset($request->from_date)) {
            $query->whereDate('stock.sto_created_at', '=', $start);
        } elseif (isset($request->to_date)) {
            $query->whereDate('stock.sto_created_at', '=', $end);
        }

        $parts_title = ProductsModel::whereIn('par_status', ['Opening', 'Created'])
            ->where('company_id', $auth->company_id)
            ->get();
        // $query = $query->get();

        if ($request->pdf_download == '1') {
            $query = $query->orderBy('sto_id', 'DESC')->get();
            $pdf = PDF::loadView($prnt_page_dir, compact('job_no', 'from_date', 'to_date', 'query', 'part_name'));
            $pdf->setPaper('A4', 'Landscape');
            return $pdf->stream($pge_title . '_x.pdf');
        } else {
            $query = $query->orderBy('sto_id', 'DESC')->paginate($pagination_number);
            return view('reports.stock_report', compact('job_no', 'parts_title', 'from_date', 'to_date', 'query', 'part_name'))->with('pageTitle', 'Stock Report');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('opening_stock/add_opening_stock')->with('pageTitle', 'Create Stock Movement');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            // coding from shahzaib start
            $tbl_var_name = 'os';
            $prfx = 'mod';
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->get_ip();

            $brwsr_col = $prfx . '_browser_info';
            $ip_col = $prfx . '_ip_address';
            $updt_date_col = $prfx . '_updated_at';

            $$tbl_var_name->$brwsr_col = $brwsr_rslt;
            $$tbl_var_name->$ip_col = $clientIP;
            $$tbl_var_name->$updt_date_col = Carbon::now();
            // coding from shahzaib end
        });
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
