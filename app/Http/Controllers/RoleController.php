<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:role-list', ['only' => ['index','show']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $auth = Auth::user();

        $roles = Role::where('company_id', $auth->company_id);
        if ($auth->type == 'Master') {
            $roles->where('company_id', $auth->company_id);
        }else{
            $roles->where('type' , '!=' , 1);
        }
        $roles = $roles->orderBy('id','DESC')->paginate(30);
        return view('roles.index',compact('roles'))->with('pageTitle', 'Role List');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $permission = Permission::get();
        $permission = Permission::where('level',1)->orderBy('code','ASC')->get();
        $permissions = Permission::where('level',2)->orderBy('code','ASC')->get();
        $permissionss = Permission::where('level',3)->orderBy('code','ASC')->get();
        return view('roles.create',compact('permission','permissions','permissionss'))->with('pageTitle', 'Role Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth = Auth::user();
        $this->validate($request, [
            'roles' => [
                'required',
                Rule::unique('roles', 'name')->where(function ($query) use ($auth) {
                    return $query->where('company_id', $auth->company_id);
                }),
            ],
            'permission' => 'required',
        ]);



        $role = Role::create([
            'name' => $request->roles,
            'company_id' => $auth->company_id,
            'created_by' => $auth->id,
            'type' => 2
        ]);
        // Convert permissions from strings to integers
        $permissions = array_map('intval', $request->input('permission'));

        // Ensure all permissions are valid
        $validPermissions = Permission::whereIn('id', $permissions)->pluck('id')->toArray();

        if (empty($validPermissions)) {
            return redirect()->back()->withErrors(['error' => 'No valid permissions found']);
        }

        $role->syncPermissions($validPermissions);// Convert permissions from strings to integers
        $permissions = array_map('intval', $request->input('permission'));

        // Ensure all permissions are valid
        $validPermissions = Permission::whereIn('id', $permissions)->pluck('id')->toArray();

        if (empty($validPermissions)) {
            return redirect()->back()->withErrors(['error' => 'No valid permissions found']);
        }

        $role->syncPermissions($validPermissions);

        return redirect()->route('roles.create')
            ->with('success','Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return view('roles.show',compact('role','rolePermissions'))->with('pageTitle', 'Show Roles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {



        $role = Role::find($id);
//        $permission = Permission::get();

        $permission = Permission::where('level',1)->orderBy('code','ASC')->get();
        $permissions = Permission::where('level',2)->orderBy('code','ASC')->get();
        $permissionss = Permission::where('level',3)->orderBy('code','ASC')->get();

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
//            ->get();

//        dd($rolePermissions);

//        dd($rolePermissions);

        return view('roles.edit',compact('role','permission','rolePermissions','permissions','permissionss'))->with('pageTitle', 'Edit Role');
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
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required|array', // Ensure 'permission' is an array
        ]);

        $role = Role::find($id);
        if (!$role) {
            return redirect()->back()->withErrors(['error' => 'Role not found']);
        }

        $role->name = $request->input('name');
        $role->save();

        // Convert permissions from strings to integers
        $permissions = array_map('intval', $request->input('permission'));

        // Ensure all permissions are valid
        $validPermissions = Permission::whereIn('id', $permissions)->pluck('id')->toArray();

        if (empty($validPermissions)) {
            return redirect()->back()->withErrors(['error' => 'No valid permissions found']);
        }

        $role->syncPermissions($validPermissions);

        return redirect()->route('roles.create')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
            ->with('success','Role deleted successfully');
    }


}
