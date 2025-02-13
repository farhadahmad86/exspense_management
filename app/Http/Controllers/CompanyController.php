<?php

namespace App\Http\Controllers;

use App\Models\CompanyModel;
use App\Models\CompanyProfile;
use App\Models\Technician;
use App\Models\User;
use Carbon\Carbon;
use Faker\Provider\ar_EG\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CompanyController extends Controller
{
    public function create()
    {
        // dd(1);
        // dd(Auth::user());
        return view('company.add_company');
    }
    public function store(Request $request)
    {
        // dd($request->all());

        DB::transaction(function () use ($request) {
            // $this->validation($request);

            $auth = Auth::user();
            // dd($auth);
            $company = new CompanyModel();
            $company->nc_name = $request->company_name;
            $company->nc_contact = $request->number;
            // $company->nc_created_by = $auth->id;
            $company->save();
            $permission = Permission::pluck('id');
            $modular_group = Role::create(['name' => 'Master ' . $company->nc_name, 'created_by' => $auth->id, 'company_id' => $company->nc_id, 'type' => 1]);

            $modular_group->syncPermissions($permission);
            // dd($modular_group);

            // Master

            $master = new User();
            $master->name = 'Master' . $company->nc_name;
            $master->password = bcrypt('All@h512');
            $master->confirm_password = bcrypt('All@h512');
            $master->login_status = 1;
            $master->email = 'master' .$company->nc_name. '@gmail.com';
            $master->username = 'master' .$company->nc_name;
            $master->employee_status = 1;
            $master->company_id = $company->nc_id;
            $master->type = 'Master';
            $master->number = $request->number;
            $master->cnic = '';
            $master->role = 1;
            $master->save();
            $master->assignRole($modular_group->id);
            // Super Admin

            $sadmin = new User();
            $sadmin->name = 'sadmin' . $company->nc_name;
            $sadmin->password = bcrypt('All@h786');
            $sadmin->confirm_password = bcrypt('All@h786');
            $sadmin->login_status = 1;
            $sadmin->email = $company->nc_name. '@gmail.com';
            $sadmin->username = $company->nc_name;
            $sadmin->employee_status = 1;
            $sadmin->company_id = $company->nc_id;
            $sadmin->type = 'Employee';
            $sadmin->number = $request->number;
            $sadmin->cnic = '';
            $sadmin->save();

            // Company Profile Add

            $company_profile = new CompanyProfile();
            $company_profile->cp_name = $request->company_name;
            $company_profile->company_id = $company->nc_id;
            $company_profile->cp_contact = $request->number;
            $company_profile->save();
        });

        return redirect()->route('add_company')->with('success', 'Successfully Saved');
    }
    public function company_list(Request $request)
    {
        $auth = Auth::user();
        $ar = json_decode($request->array);
        $search_category = $request->search_category;
        $bra_name = $request->bra_name;
        $search_model = $request->search_model;
        $pagination_number = empty($ar) ? 30 : 100000000;
        // $datas = ModelTable::all();
        // $brands = Brand::where('company_id', $auth->company_id)->get();
        // $categorys = Category::where('company_id', $auth->company_id)->get();

        $datas = DB::table('new_company');
        // dd($datas);

        $query = $datas;

        // if ($search_category) {
        //     $query->where('categories.cat_name', 'like', '%' . $search_category . '%');
        // }

        // if ($bra_name) {
        //     $query->where('brands.bra_name', 'like', '%' . $bra_name . '%');
        // }

        // if ($search_model) {
        //     $query->where('model_table.mod_name', 'like', '%' . $search_model . '%');
        // }

        $query = $query->orderBy('nc_id', 'DESC')->paginate($pagination_number);

        return view('company.company_list', compact('query'))->with('pageTitle', 'Company List');
    }
}
