<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Convert;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\StockSupplier;

class StockSupplierController extends Controller
{
    public function index(){
        return view('data-master.stock-supplier.index');
    }

    public function detail($fc_divisioncode, $fc_branch, $fc_stockcode, $fc_barcode, $fc_suppliercode){
        return StockSupplier::where([
            'fc_divisioncode' => $fc_divisioncode,
            'fc_barcode' => $fc_barcode,
            'fc_branch' => $fc_branch,
            'fc_stockcode' => $fc_stockcode,
            'fc_suppliercode' => $fc_suppliercode,
        ])->first();
    }

    public function datatables(){
        $data = StockSupplier::with('branch', 'supplier', 'stock')->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
        $validator = Validator::make($request->all(), [
            'fc_divisioncode' => 'required',
            'fc_stockcode' => 'required',
            'fc_barcode' => 'required',
            'fc_suppliercode' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->request->add(['fc_branch' => auth()->user()->fc_branch]);
        if(empty($request->type)){
            $cek_data = StockSupplier::where([
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch,
                'fc_stockcode' => $request->fc_stockcode,
                'fc_barcode' => $request->fc_barcode,
                'fc_suppliercode' => $request->fc_suppliercode,
                'deleted_at' => null
            ])->withTrashed()->count();

            if($cek_data > 0){
                return [
                    'status' => 300,
                    'message' => 'Oops! Insert gagal karena data sudah ditemukan didalam sistem kami'
                ];
            }
        }

        $request->merge(['fm_purchase' => Convert::convert_to_double($request->fm_purchase) ]);
        // $request->merge(['fm_price_customer' => Convert::convert_to_double($request->fm_price_customer) ]);
        $request->merge(['fm_price_default' => Convert::convert_to_double($request->fm_price_default) ]);
        $request->merge(['fm_price_distributor' => Convert::convert_to_double($request->fm_price_distributor) ]);
        $request->merge(['fm_price_project' => Convert::convert_to_double($request->fm_price_project) ]);
        $request->merge(['fm_price_dealer' => Convert::convert_to_double($request->fm_price_dealer) ]);
        $request->merge(['fm_price_enduser' => Convert::convert_to_double($request->fm_price_enduser) ]);
        $request->request->add(['fd_inputdate' => Carbon::now()]);

        if($request->has('fm_price_customer') || $request->has('fm_price_default') || $request->has('fm_price_distributor') || $request->has('fm_price_project') || $request->has('fm_price_dealer') || $request->has('fm_price_enduser')){
            $request->request->add(['fd_update' => Carbon::now()]);
        }
        
        if($request->type = "update"){
            StockSupplier::updateOrCreate([
                'id' => $request->id
            ], $request->all());
        } else {
            StockSupplier::updateOrCreate([
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch,
                'fc_stockcode' => $request->fc_stockcode,
                'fc_barcode' => $request->fc_barcode,
                'fc_suppliercode' => $request->fc_suppliercode,
            ], $request->all());   
        }

		return [
			'status' => 200, // SUCCESS
			'message' => 'Data berhasil disimpan'
		];
        // dd($request);
    }

    public function delete($fc_divisioncode, $fc_branch, $fc_stockcode, $fc_barcode, $fc_suppliercode){
        StockSupplier::where([
            'fc_divisioncode' => $fc_divisioncode,
            'fc_barcode' => $fc_barcode,
            'fc_branch' => $fc_branch,
            'fc_stockcode' => $fc_stockcode,
            'fc_suppliercode' => $fc_suppliercode,
        ])->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }
}
