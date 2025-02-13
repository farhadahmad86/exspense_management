<?php

namespace App\Http\Controllers;

use App\Models\EmployeeRegistrationModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $change_password = User::where('id', '=', $user->id)->where('company_id',$user->company_id)->first();
        // dd($change_password);
        return view('settings/change_password', compact('change_password'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use( $request ) {
            $auth = Auth::user();
            $employee_registration = new User();
            $employee_registration->name = $request->name;
//        $employee_registration->username=$request->name;
            $employee_registration->email = $request->email;
            $employee_registration->password = bcrypt($request->password);
            $employee_registration->user_role = $request->user_role;
            $employee_registration->user_assign_modular_grp = $request->assign_moduler_grp;
            $employee_registration->user_contant_number = $request->contact_no;
            $employee_registration->user_cnic = $request->cnic;


            // coding from shahzaib start
            $tbl_var_name = 'employee_registration';
            $prfx = '';
            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->get_ip();

            $brwsr_col = $prfx . 'browser_info';
            $ip_col = $prfx . 'ip_address';
            $updt_date_col = $prfx . 'updated_at';

            $$tbl_var_name->$brwsr_col = $brwsr_rslt;
            $$tbl_var_name->$ip_col = $clientIP;
            $$tbl_var_name->$updt_date_col = Carbon::now('GMT+5');
            // coding from shahzaib end


            $employee_registration->save();
        });
        return redirect()->back()->with('success', 'Successfully Saved');


//        $auth = Auth::user();
//        $change_password = new User();
////        $change_password = EmployeeRegistrationModel::where('id','=',$id)->first();
//        $change_password->password=bcrypt($request->password);
//
//        // coding from shahzaib start
//        $tbl_var_name = 'change_password';
//        $prfx = '';
//        $brwsr_rslt = $this->getBrwsrInfo();
//        $clientIP = $this->get_ip();
//
//        $brwsr_col = $prfx . 'browser_info';
//        $ip_col = $prfx . 'ip_address';
//        $updt_date_col = $prfx . 'updated_at';
//
//        $$tbl_var_name->$brwsr_col = $brwsr_rslt;
//        $$tbl_var_name->$ip_col = $clientIP;
//        $$tbl_var_name->$updt_date_col = Carbon::now('GMT+5');
//        // coding from shahzaib end
//
//
//        $change_password->save();
//        return redirect()->back()->with('success','Successfully Saved');
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


        $current_password = Auth::user()->password;

        if (Hash::check($request->old_password, $current_password)) {
            $user_id = Auth::user()->id;
            $change_password = User::where('id', '=', $user_id)->first();
            $change_password->password = Hash::make($request->new_password);

            $brwsr_rslt = $this->getBrwsrInfo();
            $clientIP = $this->get_ip();


            $change_password->browser_info = $brwsr_rslt;
            $change_password->ip_address = $clientIP;
            $change_password->updated_at = Carbon::now('GMT+5');

            $change_password->save();

            return redirect()->back()->with('success', 'Password Updated Successfully');

        } else {
            return redirect()->back()->with('fail', 'Password not Change old password not match current password');

        }
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
