<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use DataTables;
use Carbon\Carbon;

use App\Models\User;
use App\Models\MasterMenu;

class SettingUserController extends Controller
{
    public function index(){
        return view('data-master.master-user.index');
    }

    public function detail($id){
        return User::with('master_role')->find($id);
    }

    public function datatables(){
        $data = User::orderBy('id','desc')->with('master_role')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
       $validator = Validator::make($request->all(), [
            'master_role_id' => 'required',
            'name' => 'required',
            'email' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->request->add(['password' => Hash::make('user')]);

        User::updateOrCreate(['id' => $request->id],$request->all() );

        return response()->json([
            'status' => 200,
            'message' => "Data berhasil ditambahkan"
        ]);
    }

    public function delete($id){
        $delete = User::find($id);

		if($delete != null){

			$delete->delete();

			return response()->json([
				'status' => 200,
				'message' => "Data berhasil dihapus"
			]);
		}else{
			return response()->json([
				'status' => 300, // FAILED
				'message' => "Proses gagal, Data tidak ditemukan"
			]);
		}
    }
}
