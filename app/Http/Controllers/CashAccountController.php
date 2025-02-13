<?php

namespace App\Http\Controllers;

use App\Models\CashAccountModel;
use App\Models\CashBookModel;
use App\Models\CashPaymentVoucherModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CashAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    function __construct()
    {
        $this->middleware('permission:cash-account-list', ['only' => ['index','show']]);
        $this->middleware('permission:cash-account-create', ['only' => ['create','store']]);
    }


    public function index(Request $request)
    {
        $auth = Auth::user();
        // dd($auth);
        $ar = json_decode($request->array);
        $account_name = $request->account_name;

        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $start = date('Y-m-d', strtotime($from_date));
        $end = date('Y-m-d', strtotime($to_date));

        $pagination_number = empty($ar) ? 30 : 100000000;
        $datas = DB::table('cash_account')
            ->leftJoin('users', 'users.id','=', 'cash_account.ca_user_id')
            ->where('cash_account.company_id', $auth->company_id);
        $query = $datas;

        if (isset($request->account_name)) {
            $query->orWhere('cash_account.ca_name', 'like', '%' . $request->account_name . '%');
        }
        if ((!empty($request->from_date)) && (!empty($request->to_date))) {
            $query->whereDate('cash_account.ca_created_at', '>=', $start)
                ->whereDate('cash_account.ca_created_at', '<=', $end);
            // dd($query->toSql(), $query->getBindings(),$start,$end);
        }
        if (isset($request->from_date)) {
            $query->whereDate('cash_account.ca_created_at', '=', $start);
            // dd($query->toSql(), $query->getBindings(),$start);
        }
        if (isset($request->to_date)) {
            $query->whereDate('cash_account.ca_created_at', '=', $end);
        }

        $query = $query
            ->orderBy('ca_id', 'DESC')
            ->paginate($pagination_number);
        $cash_title = DB::table('cash_account')
            ->leftJoin('users', 'users.id','=', 'cash_account.ca_user_id')
            ->where('cash_account.company_id', $auth->company_id)
            ->get();

        // $query = $query->get();

        return view('cash_account/cash_account_list', compact('cash_title','account_name', 'from_date', 'to_date', 'query'))->with('pageTitle', 'Cash Account List');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cash_account/add_cash_account')->with('pageTitle', 'Create Cash Account');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use( $request ) {
            // $this->validation($request);
            $this->validation($request);

            $auth = Auth::user();
            $cash_account = new CashAccountModel();
            $cash_account->ca_name = $request->cash_account;
            $cash_account->ca_balance = $request->opening_balance;
            $cash_account->ca_ip_address = $this->get_ip();
            $cash_account->ca_browser_info = $this->getBrwsrInfo();
            $cash_account->ca_user_id = $auth->id;
            $cash_account->company_id = $auth->company_id;
            $cash_account->save();
            //        add cash book data
            $cash_book = new CashBookModel();
            $cash_book->cb_ca_id = $cash_account->ca_id;
            $cash_book->cb_user_id = $auth->id;
            $cash_book->company_id = $auth->company_id;
            $cash_book->cb_type = "Opening_Stock";
            $cash_book->cb_type_id = $cash_account->ca_id;
            $cash_book->cb_in = $request->opening_balance;
            $cash_book->cb_total = $request->opening_balance;
            $cash_book->save();


        });

//        return to_route('cash_account.create')->with('success', 'Cash Account has been added');
        return redirect()->back()->with('success','Successfully Saved');
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
        $cash_account = CashAccountModel::where('company_id', $auth->company_id)->where('ca_id','=',$id)->first();
        return view('cash_account/edit_cash_account ',compact('cash_account'))->with('pageTitle', 'Edit Cash Account');
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
        DB::transaction(function () use( $request , $id) {
            $auth = Auth::user();
            $cash_account = CashAccountModel::where('company_id', $auth->company_id)->where('ca_id', '=', $id)->first();
            $cash_account->ca_name = $request->cash_account;
            $cash_account->ca_balance = $request->opening_balance;
            $cash_account->ca_ip_address = $this->get_ip();
            $cash_account->ca_browser_info = $this->getBrwsrInfo();
            $cash_account->ca_user_id = $auth->id;
            $cash_account->company_id = $auth->company_id;
            $cash_account->save();
        });
        return redirect()->route('cash_account.index')->with('success', 'Successfully Updated');

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


    public function validation($request)
    {
        $auth = Auth::user();
        $this->validate($request, [
            'cash_account' => [
                'required',
                Rule::unique('cash_account', 'ca_name')->where(function ($query) use ($auth) {
                    return $query->where('company_id', $auth->company_id);
                }),
            ],
            'opening_balance' => 'required',
        ]);
        // return $this->validate($request,[
        //     'cash_account' => ['required', 'string','unique:cash_account,ca_name'],
        // ]);

    }

}
