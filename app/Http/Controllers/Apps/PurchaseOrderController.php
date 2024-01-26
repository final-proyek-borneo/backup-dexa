<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;
use App\Models\Supplier;
use App\Models\TempPoDetail;
use App\Models\TempPoMaster;
use Carbon\Carbon;
use File;
use DB;
use Yajra\DataTables\DataTables as DataTables;

class PurchaseOrderController extends Controller
{
    public function index(){
        $temp_po_master = TempPoMaster::with('branch','supplier.supplier_tax_code', 'supplier.supplier_type_business', 'supplier.supplier_typebranch', 'supplier.supplier_legal_status')->where('fc_pono',auth()->user()->fc_userid)->first();
        $temp_po_detail = TempPoDetail::where('fc_pono',auth()->user()->fc_userid)->get();
        $total = count($temp_po_detail);
        if(!empty($temp_po_master)){
            $data['data'] = $temp_po_master;
            $data['total'] = $total;
            // return view('apps.purchase-order.detail',$data);
            return view('apps.purchase-order.detail',$data);
            // dd($data);
        }
        // dd($temp_po_detail);
        return view('apps.purchase-order.index');
    }

    public function get_data_supplier_po_datatables($fc_branch){
        $data = Supplier::with('branch','supplier_legal_status','supplier_nationality','supplier_type_business','supplier_tax_code','supplier_bank1','supplier_bank2','supplier_bank2','supplier_bank3','supplier_typebranch')->where('fc_branch', $fc_branch)->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function get_data_where_field_id_get($model, $where_field, $id){
        $model = 'App\\Models\\' . $model;
        $data = $model::where($where_field, $id)->get();

        return ApiFormatter::getResponse($data);
    }

    public function store_update(Request $request){
        $validator = Validator::make($request->all(), [
            'fc_potype' => 'required',
            'fc_suppliercode' => 'required',
            'fc_status_pkp' => 'required'
        ]);
        // dd($request);
        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->request->add(['fc_pono' => auth()->user()->fc_userid]);

        $supplier = Supplier::where('fc_suppliercode', $request->fc_suppliercode)->first();

        $insert_temppomst = TempPoMaster::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_pono' => $request->fc_pono,
            'fc_potype' => $request->fc_potype,
            'fc_suppliercode' => $request->fc_suppliercode,
            'fc_suppliertaxcode' => $supplier->fc_suppliertaxcode,
            'fd_podatesysinput' => Carbon::now(),
            'fc_userid' => auth()->user()->fc_userid,
        ], $request->all());

        if($insert_temppomst){
            return [
                'status' => 201,
                'link' => '/apps/purchase-order',
                'message' => 'Data berhasil disimpan'
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Data gagal disimpan'
            ];
        }
    }

    public function delete(){
        DB::beginTransaction();

		try{
            TempPoDetail::where('fc_pono', auth()->user()->fc_userid)->delete();
            TempPoMaster::where('fc_pono', auth()->user()->fc_userid)->delete();

			DB::commit();

			return [
				'status' => 200, // SUCCESS
                'link' => '/apps/purchase-order',
				'message' => 'Data berhasil dihapus'
			];
		}

		catch(\Exception $e){

			DB::rollback();

			return [
				'status' 	=> 300, // GAGAL
				'message'       => (env('APP_DEBUG', 'true') == 'true')? $e->getMessage() : 'Operation error'
			];

		}
    }
}

