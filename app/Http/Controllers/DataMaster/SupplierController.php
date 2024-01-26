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

use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index(){
        return view('data-master.master-supplier.index');
    }

    public function detail($fc_divisioncode, $fc_branch, $fc_suppliercode){
        return Supplier::where([
            'fc_divisioncode' => $fc_divisioncode,
            'fc_branch' => $fc_branch,
            'fc_suppliercode' => $fc_suppliercode,
        ])->first();
    }

    public function datatables(){
        $data = Supplier::with(
            'branch',
            'supplier_legal_status',
            'supplier_nationality',
            'supplier_type_business',
            'supplier_tax_code',
            'supplier_typebranch',
            'supplier_bank1',
            'supplier_bank2',
            'supplier_bank3',
        )->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
        $request->request->add(['fc_branch' => auth()->user()->fc_branch]);
        $validator = Validator::make($request->all(), [
            'fc_divisioncode' => 'required',
            'fc_branch' => 'required',
            'fc_suppliercode' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
        // dd($request);
        if(empty($request->type)){
            $cek_data = Supplier::where([
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch,
                'fc_suppliercode' => $request->fc_suppliercode,
            ])->withTrashed()->count();

            if($cek_data > 0){
                return [
                    'status' => 300,
                    'message' => 'Oops! Insert gagal karena data sudah ditemukan didalam sistem kami'
                ];
            }
        }

        Supplier::updateOrCreate([
            'fc_divisioncode' => $request->fc_divisioncode,
            'fc_branch' => $request->fc_branch,
            'fc_suppliercode' => $request->fc_suppliercode,
        ], $request->all());

		return [
			'status' => 200, // SUCCESS
			'message' => 'Data berhasil disimpan'
		];
    }

    public function delete($fc_divisioncode, $fc_branch, $fc_suppliercode){
        Supplier::where([
            'fc_divisioncode' => $fc_divisioncode,
            'fc_branch' => $fc_branch,
            'fc_suppliercode' => $fc_suppliercode,
        ])->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }
}
