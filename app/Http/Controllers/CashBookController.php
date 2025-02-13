<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CashBookModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashBookController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:cash-book-list', ['only' => ['cash_book_list']]);
//        $this->middleware('permission:cash-payment-voucher-create', ['only' => ['create', 'store']]);
    }

    public function cash_book_list(Request $request)
    {
        $ar = json_decode($request->array);
        $pagination_number = empty($ar) ? 30 : 100000000;
        $auth = Auth::user();
        $datas = DB::table('cash_book')
            ->where('cash_book.company_id', $auth->company_id)
            ->leftJoin('cash_account', 'cash_account.ca_id', '=', 'cash_book.cb_ca_id')
            ->where('cash_account.company_id', $auth->company_id);
        // ->orderBy('cb_id', 'Desc');

        $account_name = $request->account_name;
        $status = $request->status;
        $job_no = $request->job_no;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $start = date('Y-m-d', strtotime($from_date));

        $end = date('Y-m-d', strtotime($to_date));
        $query = $datas;

        if (isset($request->account_name)) {
            $query->Where('cash_book.cb_ca_id', '=', $request->account_name);
        }

        if (isset($request->job_no)) {
            $query->where('cash_book.cb_job_id', '=', $request->job_no);
        }
        if (isset($request->status)) {
            $query->where('cash_book.cb_type', 'like', '%' . $request->status . '%');
        }
        if (!empty($from_date) && !empty($to_date)) {
            $query->whereDate('cash_book.cb_created_at', '>=', $start)->whereDate('cash_book.cb_created_at', '<=', $end);
        } elseif (isset($request->from_date)) {
            $query->whereDate('cash_book.cb_created_at', '=', $request->from_date);
        } elseif (isset($request->to_date)) {
            $query->whereDate('cash_book.cb_created_at', '=', $request->to_date);
        }
        $cash_title = DB::table('cash_account')
            ->where('cash_account.company_id', $auth->company_id)
            ->leftJoin('users', 'users.id', '=', 'cash_account.ca_user_id')
            ->where('users.company_id', $auth->company_id)
            ->get();
        // $query = $query->get();
        $query = $query->orderBy('cb_id', 'DESC')->paginate($pagination_number);

        return view('cash_book/cash_book_list', compact('cash_title','job_no', 'status', 'account_name', 'from_date', 'to_date', 'query'))->with('pageTitle', 'Cash Book List');
    }
}
