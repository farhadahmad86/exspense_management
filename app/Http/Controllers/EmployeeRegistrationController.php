<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\EmployeeRegistrationModel;
use App\Models\Technician;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class EmployeeRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:employee-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:employee-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:employee-edit', ['only' => ['edit', 'update']]);
    }

    public function index(Request $request)
    {
        //        $datas = DB::table('users')
        //        ->orderBy('id','Desc');

        $ar = json_decode($request->array);
        $search = $request->search;
        $login_status = $request->login_status;
        $name = $request->name;
        $emp_status = $request->emp_status;
        $tech_status = $request->tech_status;

        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $pagination_number = empty($ar) ? 30 : 100000000;
        $auth = Auth::user();
        $datas = User::query();

        $query = $datas;

        if (isset($request->name)) {
            $query->where(function ($query) use ($request) {
                $query->orWhere('users.name', 'like', '%' . $request->name . '%');
                $query->orWhere('users.f_name', 'like', '%' . $request->name . '%');
                $query->orWhere('users.email', 'like', '%' . $request->name . '%');
                $query->orWhere('users.number', 'like', '%' . $request->name . '%');
            });
        }

        if (isset($request->from_date)) {
            $query->whereDate('users.created_at', '>=', $request->from_date);
        }
        if (isset($role)) {
            $query->where('users.role', $request->role);
            //            dd($query);
        }
        //        if (isset($name)) {
        //            $query->where('users.name',  $request->name );
        ////            dd($query);
        //        }
        if (isset($emp_status)) {
            $query->where('users.employee_status', $request->emp_status);
            //            dd($query);
        }
        if (isset($login_status)) {
            $query->where('users.login_status', $request->login_status);
            //            dd($query);
        }
        if (isset($tech_status)) {
            $query->where('users.work_status', $request->tech_status);
            //            dd($query);
        }
        if (isset($request->to_date)) {
            $query->whereDate('users.created_at', '<=', $request->to_date);
        }

        if (isset($request->from_visit_search)) {
            $query->where('users.number_of_visit', '>=', $request->from_visit_search);
        }
        if (isset($request->to_visit_search)) {
            $query->where('users.number_of_visit', '<=', $request->to_visit_search);
        }

        if (isset($request->from_avg_rating_search)) {
            $query->where('users.average_rating', '>=', $request->from_avg_rating_search);
        }
        if (isset($request->to_avg_rating_search)) {
            $query->where('users.average_rating', '<=', $request->to_avg_rating_search);
        }

        // $query = $query->get();
        $query = $query->where('company_id', $auth->company_id);
        if ($auth->type == 'Master' || $auth->id == 1) {
            // dd(1);
            $query = $query->orderBy('id', 'DESC')->paginate($pagination_number);
        } else {
            // dd(2);
            $query = $query->where('id', '!=', 1)
                ->where('type', '!=', 'Master')
                ->orderBy('id', 'DESC')
                ->paginate($pagination_number);
        }
        return view('employee_registration/employee_registration_list', compact('search', 'from_date', 'to_date', 'login_status', 'name', 'emp_status', 'tech_status', 'query'))->with('pageTitle', 'Employee List');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = Auth::user();
        //        $roles = Role::pluck('name','name')->all();
        $roles = Role::where('company_id', $auth->company_id);
        if ($auth->type == 'Master') {
            $roles->where('company_id', $auth->company_id);
        } else {
            $roles->where('type', '!=', 1);
        }
        $roles = $roles->get();
        return view('employee_registration/add_employee_registration', compact('roles'))->with('pageTitle', 'Create Employee');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $this->validation($request);

            $status = $request->log_status;
            $var_status = (int) $status;

            $employee_status = $request->emp_status;
            $var_statuss = (int) $employee_status;

            $auth = Auth::user();
            $EmployeeRegistration = new User();
            $EmployeeRegistration->name = $request->name;
            $EmployeeRegistration->f_name = $request->father_name;
            $EmployeeRegistration->address = $request->address;
            $EmployeeRegistration->password = bcrypt($request->password);
            $EmployeeRegistration->confirm_password = bcrypt($request->confirm_password);
            $EmployeeRegistration->login_status = $var_status;
            $EmployeeRegistration->gender = $request->gender;
            $EmployeeRegistration->email = $request->email;
            $EmployeeRegistration->username = $request->username;
            $EmployeeRegistration->employee_status = $var_statuss;
            $EmployeeRegistration->number = $request->number;
            $EmployeeRegistration->cnic = $request->cnic;
            $EmployeeRegistration->company_id = $auth->company_id;
            $EmployeeRegistration->type = 'Employee';
            $EmployeeRegistration->role = $request->roles;

            // coding from shahzaib start
            $tbl_var_name = 'EmployeeRegistration';
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

            //            roles
            $EmployeeRegistration->save();
            $role = Role::find($request->input('roles'));
            if ($role) {
                $EmployeeRegistration->assignRole($role);
            } else {
                // Handle the case where the role is not found
                return redirect()->back()->withErrors(['role' => 'Role not found']);
            }

        });
        return redirect()
            ->back()
            ->with('success', 'Successfully Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $user = User::find($id);
        // dd($user);
        $roles = Role::where('company_id', $auth->company_id);
        if ($auth->type == 'Master') {
            $roles->where('company_id', $auth->company_id);
        } else {
            $roles->where('type', '!=', 1);
        }
        $roles = $roles->get();
        // dd($roles);
        // $userRole = $user->roles->first();
        //    $userRole = $user->roles;

        //    dd($userRole);
        //        dd($roles,$userRole->id);
        //        $userRole = $user->roles->pluck('name','name')->all();
        $employee_registration = User::where('id', '=', $id)->first();
        return view('employee_registration/edit_employee_registration', compact('employee_registration', 'roles'))->with('pageTitle', 'Edit Employee');
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
        DB::transaction(function () use ($request, $id) {
            // dd($request->all());
            $auth = Auth::user();
            $employee_registration = User::where('id', '=', $id)
                ->where('company_id', $auth->company_id)
                ->first();
            $status = $request->log_status;
            $var_status = (int) $status;

            $employee_status = $request->emp_status;
            $var_statuss = (int) $employee_status;


            $employee_registration->name = $request->name;
            $employee_registration->f_name = $request->father_name;
            $employee_registration->address = $request->address;
            //            $employee_registration->password = bcrypt($request->password);
            $employee_registration->confirm_password = bcrypt($request->confirm_password);
            $employee_registration->login_status = $var_status;
            $employee_registration->gender = $request->gender;
            //            $employee_registration->email = $request->email;
            $employee_registration->employee_status = $var_statuss;
            $employee_registration->number = $request->number;
            $employee_registration->cnic = $request->cnic;
            $employee_registration->company_id = $auth->company_id;
            $employee_registration->type = 'Employee';
            $employee_registration->role = $request->roles;

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

            //            roles
            DB::table('model_has_roles')
                ->where('model_id', $id)
                ->delete();
            $role = Role::find($request->input('roles'));
            if ($role) {
                $employee_registration->assignRole($role);
            } else {
                // Handle the case where the role is not found
                return redirect()->back()->withErrors(['role' => 'Role not found']);
            }
        });
        return redirect()
            ->route('employee_registration.index')
            ->with('success', 'Successfully Updated');
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
            'name' => [
                'required',
                Rule::unique('users', 'name')->where(function ($query) use ($auth) {
                    return $query->where('company_id', $auth->company_id);
                }),
            ],
            'email' => ['nullable', 'string', 'unique:users,email'],
            'username' => ['nullable', 'string', 'unique:users,username'],
        ]);
        // return $this->validate($request, [
        //     'email' => ['nullable', 'string', 'unique:users,email'],
        //     'name' => ['required', 'string', 'unique:users,name'],
        // ]);
    }
}
