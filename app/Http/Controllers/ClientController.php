<?php

namespace App\Http\Controllers;

use App\Models\ClientModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:client-list', ['only' => ['index']]);
        $this->middleware('permission:client-edit', ['only' => ['edit','update']]);
    }




    public function index(Request $request)
    {
        $auth = Auth::user();
        $client_name = $request->client_name;
        $ar = json_decode($request->array);
        $datas = ClientModel::all();
        $datas = DB::table('client')
            ->leftJoin('users', 'users.id','=', 'client.cli_user_id')
            ->where('client.company_id', $auth->company_id)
            ->orderBy('cli_id','Desc');
        $pagination_number = empty($ar) ? 30 : 100000000;
        $query = $datas;

        if (isset($request->client_name)) {
            $query->where(function ($query) use ($request) {
                $query->orWhere('client.cli_name', 'like', '%' . $request->client_name . '%');
                $query->orWhere('client.cli_number', 'like', '%' . $request->client_name . '%');
            });
        }
        $client_title = DB::table('client')
            ->leftJoin('users', 'users.id','=', 'client.cli_user_id')->get();
        // $query = $query->get();
        $query = $query->orderBy('cli_id', 'DESC')->paginate($pagination_number);

        return view('client/client_list', compact('client_name','client_title', 'query'))->with('pageTitle', 'Client List');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client/add_client')->with('pageTitle', 'Create Client');
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

            $auth = Auth::user();
            $client = new ClientModel();
            $client->cli_name=$request->client_name;
            $client->cli_number=$request->client_number;
            $client->cli_address=$request->client_address;
            $client->cli_remarks=$request->remarks;
            $client->cli_user_id=$auth->id;
            $client->company_id=$auth->company_id;
            $client->cli_browser_info=$this->getBrwsrInfo();
            $client->cli_ip_address=$this->get_ip();
            $client->cli_created_at	=Carbon::now();
            $client->save();
        });
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
        $client = ClientModel::where('cli_id','=',$id)->where('company_id', $auth->company_id)->first();
        return view('client/edit_client',compact('client'))->with('pageTitle', 'Edit Client');
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
            $client = ClientModel::where('cli_id', '=', $id)->first();

            $client->cli_number = $request->client_number;
            $client->cli_name = $request->client_name;
            $client->cli_address = $request->client_address;
            $client->cli_remarks = $request->remarks;
            $client->cli_user_id = $auth->id;
            $client->company_id = $auth->company_id;
            // coding from shahzaib start
            $tbl_var_name = 'client';
            $prfx = 'cli';
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->get_ip();

            $brwsr_col = $prfx . '_browser_info';
            $ip_col = $prfx . '_ip_address';
            $updt_date_col = $prfx . '_updated_at';

            $$tbl_var_name->$brwsr_col = $brwsr_rslt;
            $$tbl_var_name->$ip_col = $clientIP;
            $$tbl_var_name->$updt_date_col = Carbon::now('GMT+5');
            // coding from shahzaib end
            $client->save();
        });
        return redirect()->route('client.index')->with('success', 'Successfully Updated');
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
