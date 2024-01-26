<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument; 
use App\Helpers\Convert;

use Yajra\DataTables\DataTables as DataTables;
use File;
use DB;

use App\Models\Warehouse;
use App\Models\Invstore;
use App\Models\ScanQr;
use Auth;

class PenggunaanCprrController extends Controller
{

    public function index(){
        return view('apps.penggunaan-cprr.index');
    }

    public function detail($fc_warehousecode)
    {
        $fc_warehousecode = base64_decode($fc_warehousecode);
        $data['gudang_mst'] = Warehouse::where('fc_warehousecode', $fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->first();
        return view('apps.penggunaan-cprr.detail', $data);
        // dd($data);
    }

    public function datatables(){
        $data = Warehouse::where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->where('fc_warehousepos', 'EXTERNAL')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sum_quantity', function ($row) {
                $groupedScanner = ScanQr::where('fc_warehousecode', $row->fc_warehousecode)
                    ->selectRaw("SUBSTRING(fc_barcode, 1, 40) as grouped_barcode, COUNT(*) as count")
                    ->groupBy('grouped_barcode')
                    ->get();

                $sumQuantity = $groupedScanner->count();

                return $sumQuantity;
            })
            ->make(true);
    }

    public function datatables_detail($fc_warehousecode)
    {
        $data = ScanQr::with('invstore.stock')
            ->where([
                'fc_warehousecode' => $fc_warehousecode,
                'fc_branch' => auth()->user()->fc_branch,
            ])
            ->orderBy('fc_scanqrstatus', 'ASC')
            ->orderBy('fd_scanqrdate', 'DESC')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function detail_unjournal($fc_warehousecode)
    {   
        $data = ScanQr::with('invstore.stock')
            ->where('fc_warehousecode', $fc_warehousecode)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_scanqrstatus', 'F')
            ->get();

        return ApiFormatter::getResponse($data);
    }

    public function journal_cprr ($fc_warehousecode, $fc_membercode){
        DB::beginTransaction();

        try {
            DB::select('CALL AUTOJOURNAL_SCANQR(?,?,?,?)', array(
                Auth()->user()->fc_divisioncode, 
                Auth()->user()->fc_branch,
                $fc_membercode,
                $fc_warehousecode
            ));

            $data = ScanQr::where('fc_warehousecode', $fc_warehousecode)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_scanqrstatus', 'F')
            ->update(['fc_scanqrstatus' => 'T']);

            DB::commit();

            return [
                'status' => 201,
                'message' => 'Data berhasil dijurnal',
            ];
    
        } catch (\Exception $e) {
            DB::rollBack();

            return [
				'status' 	=> 300, // GAGAL
				'message'       => (env('APP_DEBUG', 'true') == 'true')? $e->getMessage() : 'Operation error'
			];
        }
    }
}
