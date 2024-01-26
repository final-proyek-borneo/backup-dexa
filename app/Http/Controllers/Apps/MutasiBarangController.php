<?php

namespace App\Http\Controllers\Apps;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Invstore;
use App\Models\SoDetail;
use App\Models\TempMutasiDetail;
use App\Models\TempMutasiMaster;
use App\Models\SoMaster;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use Yajra\DataTables\DataTables as DataTables;

use Carbon\Carbon;
use DB;

class MutasiBarangController extends Controller
{
    public function index() 
    {
        $temp_mutasi_master = TempMutasiMaster::with('warehouse_start','warehouse_destination')->where('fc_mutationno',auth()->user()->fc_userid)->first();
        $temp_mutasi_detail = TempMutasiDetail::where('fc_mutationno',auth()->user()->fc_userid)->get();
        $total = count($temp_mutasi_detail);
        if(!empty($temp_mutasi_master)){
            $data['data'] = $temp_mutasi_master;
            $data['total'] = $total;
            // return view('apps.purchase-order.detail',$data);
            return view('apps.mutasi-barang.detail',$data);
            // dd($data);
        }
        // dd($temp_po_detail);
        return view('apps.mutasi-barang.index');
    }

    public function datatables_so_detail($fc_sono){
        $decode_fc_sono = base64_decode($fc_sono);
        $data = SoDetail::with('branch', 'warehouse', 'stock', 'namepack', 'somst.domst')->where('fc_sono', $decode_fc_sono)->get();

        return DataTables::of($data)
            ->addColumn('total_harga', function ($item) {
                return $item->fn_so_qty * $item->fm_so_oriprice;
            })
            ->addIndexColumn()
            ->make(true);
        // dd($domst);
    }

    public function datatables_stock_inventory($fc_stockcode,$fc_warehousecode){
        // get data from Invstore
        $decode_fc_stockcode = base64_decode($fc_stockcode);
        $data = Invstore::with('stock.sodtl.somst', 'warehouse')->where('fc_stockcode', $decode_fc_stockcode)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->where('fc_warehousecode', $fc_warehousecode)
        ->where('fn_quantity','>', 0)
        ->orderBy('fd_expired', 'ASC')
        ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    
    public function datatables_so_cprr($fc_membercode){
        $data = SoMaster::with('customer')
        ->where('fc_sotype', 'Cost Per Test')
        ->where('fc_membercode', $fc_membercode)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function datatables_so_internal(){
        $data = SoMaster::with('customer')
        ->where('fc_sotype', 'Memo Internal')
        ->whereIn('fc_sostatus',['F', 'P'])
        ->where('fc_branch', auth()->user()->fc_branch)
        ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function datatables_lokasi_awal($fc_type_mutation){
        if($fc_type_mutation == 'INTERNAL'){
            $data = Warehouse::with('branch')->where('fc_warehousepos', $fc_type_mutation)->where('fc_branch', auth()->user()->fc_branch)->orderBy('created_at', 'DESC')->get();
        }else{
            $data = Warehouse::with('branch')->where('fc_branch', auth()->user()->fc_branch)->orderBy('created_at', 'DESC')->get();
        }
        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function datatables_lokasi_tujuan($fc_type_mutation){
        if($fc_type_mutation == 'INTERNAL'){
            $data = Warehouse::with('branch')->where('fc_warehousepos', $fc_type_mutation)->where('fc_branch', auth()->user()->fc_branch)->orderBy('created_at', 'DESC')->get();
        }else{
            $data = Warehouse::with('branch')->where('fc_branch', auth()->user()->fc_branch)->orderBy('created_at', 'DESC')->get();
        }

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_mutasi(Request $request){

        // validator
        $validator = Validator::make($request->all(), [
            'fd_date_byuser' => 'required',
            'fc_type_mutation' => 'required',
            'fc_startpoint' => 'required',
            'fc_destination' => 'required',
            'fc_sono' => 'required',
        ], [
            'fc_sono.required' => 'SO wajib diisi',
        ]);
        
        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        if($request->fc_startpoint == $request->fc_destination){
            return [
                'status' => 300,
                'message' => "Lokasi awal dan lokasi tujuan tidak boleh sama"
            ];
        }

        $dateByuser = Carbon::createFromFormat('m/d/Y', $request->fd_date_byuser,)->format('Y-m-d H:i:s');
        // create ke TempMutasiMaster
        $insert =  TempMutasiMaster::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_mutationno' => auth()->user()->fc_userid,
            'fc_operator' => auth()->user()->fc_userid,
            'fd_date_byuser' => $dateByuser,
            'fc_type_mutation' => $request->fc_type_mutation,
            'fc_sono' => $request->fc_sono,
            'fc_startpoint_code' => $request->fc_startpoint,
            'fc_destination_code' => $request->fc_destination,
       ]);

         if($insert){
                return [
                 'status' => 201,
                 'message' => 'Data berhasil disimpan',
                 'link' => '/apps/mutasi-barang'
                ];
        }else{
                return [
                 'status' => 300,
                 'message' => 'Data gagal disimpan'
                ];
        }
    }

    public function cancel_mutasi(){
        DB::beginTransaction();

		try{
            TempMutasiDetail::where('fc_mutationno', auth()->user()->fc_userid)->delete();
            TempMutasiMaster::where('fc_mutationno', auth()->user()->fc_userid)->delete();

			DB::commit();

			return [
				'status' => 201, // SUCCESS
                'link' => '/apps/mutasi-barang',
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

    public function delete(){
        DB::beginTransaction();

		try{
            TempMutasiMaster::where('fc_mutationno', auth()->user()->fc_userid)->delete();
            TempMutasiDetail::where('fc_mutationno', auth()->user()->fc_userid)->delete();

			DB::commit();

			return [
				'status' => 200, // SUCCESS
                'link' => '/apps/mutasi-barang',
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
