<?php

namespace App\Http\Controllers;

use App\Models\PartyModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PartyController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:sale-purchase-party-list', ['only' => ['party_list']]);
        $this->middleware('permission:sale-purchase-party-create', ['only' => ['add_party','store_party']]);
        $this->middleware('permission:sale-purchase-party-edit', ['only' => ['edit_party','update_party']]);
    }



    public function add_party()
    {
        return view('party/add_party')->with('pageTitle', 'Create Party');
    }

    public function party_list(Request $request)
    {
        // $datas = PartyModel::all();
        $auth = Auth::user();
        $datas = DB::table('party')
            ->leftJoin('users', 'users.id','=', 'party.party_created_at')
            ->where('party.company_id', $auth->company_id)
            ->orderBy('party_id','Desc')
            ->paginate(30);
        // ->get();

        $query = $datas;

        return view('party/party_list', compact(  'query'))->with('pageTitle', 'Party List');
    }

    public function store_party(Request $request)
    {
        DB::transaction(function () use( $request ) {

            $this->validation($request);

            $auth = Auth::user();
            $party = new PartyModel();
            $party->party_name=ucwords($request->party);
            $party->party_number=$request->number;
            $party->party_address=$request->address;
            $party->party_created_by=$auth->id;
            $party->company_id=$auth->company_id;
//        $party->party_created_at=Carbon::now()->toDateTimeString();
//        $party->party_updated_at=$auth->id;

            // coding from shahzaib start
            $tbl_var_name = 'party';
            $prfx = 'party';
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->get_ip();

            $brwsr_col = $prfx . '_browser_info';
            $ip_col = $prfx . '_ip_address';
            $updt_date_col = $prfx . '_updated_at';

            $$tbl_var_name->$brwsr_col = $brwsr_rslt;
            $$tbl_var_name->$ip_col = $clientIP;
            $$tbl_var_name->$updt_date_col = Carbon::now('GMT+5');

//        dd(Carbon::now('GMT+5'));
            // coding from shahzaib end

            $party->save();
        });

        return redirect()->back()->with('success','Successfully Saved');

//        return redirect()->back()->with('success','Successfully Saved');
    }


    public function edit_party($id)
    {
        $auth = Auth::user();
        $party = PartyModel::where('party_id','=',$id)->where('company_id', $auth->company_id)->first();
        return view('party/edit_party',compact('party'))->with('pageTitle', 'Edit Party');

    }
    public function update_party(Request $request, $id)
    {
        DB::transaction(function () use( $request , $id) {
            $auth = Auth::user();
            $party = PartyModel::where('party_id', '=', $id)->first();

            $party->party_name = ucwords($request->party);
            $party->party_number = $request->number;
            $party->party_address = $request->address;
            $party->party_created_by=$auth->id;
            $party->company_id=$auth->company_id;
            $tbl_var_name = 'party';
            $prfx = 'party';
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->get_ip();

            $brwsr_col = $prfx . '_browser_info';
            $ip_col = $prfx . '_ip_address';
            $updt_date_col = $prfx . '_updated_at';

            $$tbl_var_name->$brwsr_col = $brwsr_rslt;
            $$tbl_var_name->$ip_col = $clientIP;
            $$tbl_var_name->$updt_date_col = Carbon::now('GMT+5');
            $party->save();
        });
        return redirect()->route('party_list')->with('success', 'Successfully Updated');

    }

    public function validation($request)
    {
        // farhad add
        $auth = Auth::user();
        return $this->validate($request, [
            'party' => [
                'required',
                Rule::unique('party', 'party_name')->where(function ($query) use ($auth) {
                    return $query->where('company_id', $auth->company_id);
                }),
            ],
            'number' => 'required',
        ]);
        // return $this->validate($request,[
        //     'party' => ['required', 'string','unique:party,party_name'],
        // ]);

    }
}
