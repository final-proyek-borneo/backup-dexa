<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\MasterMenu;

class SettingMenuController extends Controller
{
    public function index(){
        return view('data-master.master-menu.index');
    }

    public function detail($id){
        return MasterMenu::find($id);
    }

    public function datatables(){
        $master_menu = MasterMenu::where('parent_id', '0')->orderBy('index','asc')->get();

        $array = [];
        $count = 0;
        foreach($master_menu as $key => $value){
            $array[$count]['id'] = $value->id;
            $array[$count]['nama'] = $value->nama_menu;
            $array[$count]['kategori'] = $value->kategori;
            $array[$count]['index'] = $value->index;
            $array[$count]['icon'] = $value->icon;
            $array[$count]['link'] = $value->link;
            $array[$count]['status'] = "menu";

            $count++;

            $sub_menu = MasterMenu::where('parent_id', $value->id)->orderBy('index','asc')->get();
            foreach($sub_menu as $value2){
                $array[$count]['id'] = $value2->id;
                $array[$count]['nama'] = $value2->nama_menu;
                $array[$count]['kategori'] = $value->kategori;
                $array[$count]['index'] = $value2->index;
                $array[$count]['icon'] = $value2->icon;
                $array[$count]['link'] = $value2->link;
                $array[$count]['status'] = "submenu";

                $count++;
            }
        }

        return DataTables::of($array)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
       $validator = Validator::make($request->all(), [
            'nama_menu' => 'required',
            'index' => 'required',
            'parent_id' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        MasterMenu::updateOrCreate(['id' => $request->id],$request->all() );

		return [
			'status' => 200, // SUCCESS
			'message' => 'Data berhasil disimpan'
		];
    }

    public function delete($id){
        $delete = MasterMenu::find($id);

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
