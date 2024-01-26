<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;

use PDF;
use Carbon\Carbon;
use File;
use DB;

use App\Models\Invstore;
use App\Models\ScanQr;
use App\Models\Warehouse;
use App\Models\Stock;
use Yajra\DataTables\DataTables;

class ScanQrController extends Controller
{

    public function index(){
        return view('apps.scan-qr.index');
        // dd($do_master);
    }

    public function detail_barang($fc_barcode){
        // decode fc_barcode
        $decode_fc_barcode = base64_decode($fc_barcode);
        $data = Invstore::with('stock','warehouse')->where('fc_barcode', $decode_fc_barcode)->first();

        // return json status 200 jika berhasil jika gagal 300
        if ($data) {
            return response()->json([
                'status' => 200,
                'data' => $data
            ]);
        }else{
            return response()->json([
                'status' => 300,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function scan_barang(Request $request){

        // validasi
        $validator = Validator::make($request->all(), [
            'fc_barcode_scan' => 'required',
            'fc_stockcode' => 'required',
            'fc_warehousecode' => 'required',
            'fc_membercode' => 'required'
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        DB::beginTransaction();
        // create data ScanQr
        try {
            ScanQr::create([
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_barcode' => $request->fc_barcode_scan,
                'fc_warehousecode' => $request->fc_warehousecode,
                'fc_membercode' => $request->fc_membercode,
                'fc_userid' => auth()->user()->fc_userid,
                'fd_scanqrdate' => Carbon::now(),
                'fc_scanqrstatus' => 'S',
            ]);
            DB::commit();
            return [
				'status' => 201, // SUCCESS
                'link' => '/apps/penggunaan-cprr',
				'message' => 'Barang berhasil terpakai'
			];
        } catch (\Exception $e) {
            DB::rollback();

			return [
				'status' 	=> 300, // GAGAL
				'message'       => (env('APP_DEBUG', 'true') == 'true')? $e->getMessage() : 'Operation error'
			];
        }



    }
}
