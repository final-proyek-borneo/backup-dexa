<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Convert;
use App\Helpers\NoDocument;
use App\Models\User;
use Auth;
use DataTables;
use Carbon\Carbon;
use File;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MasterRoleController extends Controller
{
    public $user;
    public function __construct(){
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    public function datatable(){
        // role has permission
        $data = Role::select('id', 'name', 'guard_name')
            ->with('permissions')
            ->get();
        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function index(){
        if (is_null($this->user) || !$this->user->can('Master Role')) {
            abort(403, 'Sorry !! You are Unauthorized to create any role !');
        }

        $all_permissions  = Permission::all();
        $permission_groups = User::getpermissionGroups();
        
        return view('data-master.master-role.index', compact('all_permissions', 'permission_groups'));
    }

    public function create(Request $request){
        if (is_null($this->user) || !$this->user->can('Master Role')) {
            abort(403, 'Sorry !! You are Unauthorized to create any role !');
        }

        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles'
        ], [
            'name.requried' => 'Tolong isi nama role'
        ]);

        // Process Data
        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        // $role = DB::table('roles')->where('name', $request->name)->first();
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        return response()->json([
            'status' => 200,
            'message' => "Role User Berhasil dibuat"
        ]);
    }

    public function destroy(int $id){
        if (is_null($this->user) || !$this->user->can('Master Role')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any role !');
        }

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin role,
        // so that no-one could delete or disable it by somehow.
        if ($id === 7) {
            session()->flash('error', 'Sorry !! You are not authorized to delete this role !');
            return back();
        }

        $role = Role::findById($id, 'web');
        if (!is_null($role)) {
            $role->delete();
        }

        return response()->json([
            'status' => 200,
            'message' => "Role User Berhasil dihapus"
        ]);
    }

    public function edit(int $id){
        if (is_null($this->user) || !$this->user->can('Master Role')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any role !');
        }

        $role = Role::findById($id, 'web');
        $all_permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('data-master.master-role.edit', compact('role', 'all_permissions', 'permission_groups'));
    }

    public function update(Request $request, int $id){
        if (is_null($this->user) || !$this->user->can('Master Role')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any role !');
        }

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin role,
        // so that no-one could delete or disable it by somehow.
        if ($id === 7) {
            session()->flash('error', 'Sorry !! You are not authorized to edit this role !');
            return back();
        }

        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles,name,' . $id
        ], [
            'name.requried' => 'Please give a role name'
        ]);

        $role = Role::findById($id, 'web');
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($permissions);
        }

        
        if($role && $permissions){
            return [
                'status' => 201,
                'link' => '/data-master/master-role',
                'message' => 'Data berhasil disimpan'
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Data gagal disimpan'
            ];
        }
    }
}
