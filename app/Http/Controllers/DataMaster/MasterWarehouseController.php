<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\Warehouse;

class MasterWarehouseController extends Controller
{
    public function index(){
        return view('data-master.master-warehouse.index');
    }

    public function detail($fc_divisioncode, $fc_branch, $fc_warehousecode){
        return Warehouse::where([
            'fc_divisioncode' => $fc_divisioncode,
            'fc_branch' => $fc_branch,
            'fc_warehousecode' => $fc_warehousecode,
        ])->first();
    }

    public function datatables(){
        $data = Warehouse::with('branch')->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
        $validator = Validator::make($request->all(), [
            'fc_divisioncode' => 'required',
            'fc_membercode' => 'required_if:fc_warehouse,EXTERNAL',
            // 'fc_membercode' => 'required_if:fc_warehousepos,EXTERNAL|unique:t_warehouse,fc_membercode,NULL,fc_membercode,deleted_at,NULL',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->request->add(['fc_branch' => auth()->user()->fc_branch]);
        if(empty($request->type) && $request->fc_warehousepos == "EXTERNAL"){
            $cek_data = Warehouse::where([
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch,
                'fc_membercode' => $request->fc_membercode,
                'deleted_at' => NULL,
            ])->withTrashed()->count();

            if($cek_data > 0){
                return [
                    'status' => 300,
                    'message' => 'Oops! Insert gagal karena data sudah ditemukan didalam sistem kami'
                ];
            }
        }

        //update
        if($request->type == 'update'){
            Warehouse::where([
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch,
                'fc_warehousecode' => $request->fc_warehousecode,
            ])->update($request->except(['type']));
        }else{
            Warehouse::create( $request->except(['type']));
        }
        
		return [
			'status' => 200, // SUCCESS
			'message' => 'Data berhasil disimpan'
		];
    }

    public function delete($fc_divisioncode, $fc_branch, $fc_warehousecode){
        Warehouse::where([
            'fc_divisioncode' => $fc_divisioncode,
            'fc_branch' => $fc_branch,
            'fc_warehousecode' => $fc_warehousecode,
        ])->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }
}
