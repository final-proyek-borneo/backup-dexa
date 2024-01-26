<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use App\Models\DoDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use PDF;
use App\Models\TempReturMaster;
use App\Models\TempReturDetail;
use DB;
use Validator;
use App\Helpers\ApiFormatter;
use Carbon\Carbon;

class ReturBarangDetailController extends Controller
{
    public function datatables()
    {
        $data = TempReturDetail::with('returmst','invstore.stock')->where('fc_returno', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_do_detail($fc_dono){
        $decode_dono = base64_decode($fc_dono);
        $data = DoDetail::with('invstore.stock')->where('fc_branch', auth()->user()->fc_branch)->where('fc_dono', $decode_dono)->get();

        // dd($data);
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function store_update(Request $request){
        // validasi
        $validator = Validator::make($request->all(), [
            'fc_barcode' => 'required',
            'fc_stockcode' => 'required',
            'fn_returqty' => 'required',
            'fn_price_edit' => 'required',
        ]);
        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $tempretur_detail = TempReturDetail::where('fc_returno', auth()->user()->fc_userid)->orderBy('fn_rownum', 'DESC')->first();
        $tempretur_detail_sumquantity = TempReturDetail::where('fc_returno', auth()->user()->fc_userid)
        ->where('fc_barcode', $request->fc_barcode)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->sum('fn_returqty');

        if(($request->fn_returqty + $tempretur_detail_sumquantity) > $request->fn_qty_do){
            return [
                'status' => 300,
                'message' => 'Jumlah retur melebihi jumlah DO'
            ];
        }

        if($request->fn_returqty > $request->fn_qty_do){
            return [
                'status' => 300,
                'message' => 'Jumlah retur tidak boleh melebihi jumlah DO'
            ];
        }
   
        $fn_rownum = 1;
        if (!empty($tempretur_detail)) {
            $fn_rownum =  $tempretur_detail->fn_rownum + 1;
        }

        if ($fn_rownum === null) {
            return [
                'status' => 300,
                'link' => '/apps/retur-barang',
                'message' => 'fn_rownum cannot be null'
            ];
        }

        // insert ke ReturnDetail
        $insert_data = TempReturDetail::create([
             'fc_divisioncode' => auth()->user()->fc_divisioncode,
             'fc_branch' => auth()->user()->fc_branch,
             'fc_returno' => auth()->user()->fc_userid,
             'fc_barcode' => $request->fc_barcode,
             'fc_batch' => $request->fc_batch,
             'fc_namepack' => $request->fc_namepack,
             'fn_rownum' => $fn_rownum,
             'fc_catnumber' => $request->fc_catnumber,
             'fd_expired' => $request->fd_expired,
             'fn_price' => $request->fn_price_edit,
             'fn_disc' => $request->fn_disc,
             'fn_value' => $request->fn_value,
             'fc_status' => 'I',
             'fn_returqty' => $request->fn_returqty,
             'fv_description' => $request->fv_description
        ]);

      

        // jika insert berhasil
        if($insert_data){
            return response()->json([
               'status' => 200,
               'message' => 'Data berhasil disimpan'
           ]);
        } else{
            return [
                'status' => 300,
                'link' => '/apps/retur-barang',
                'message' => 'Error'
            ];
        }
        // dd($fn_rownum);
        
    }


    public function submit_return_barang(){
        $check_retur_dtl = TempReturDetail::where('fc_returno', auth()->user()->fc_userid)->where('fc_branch',auth()->user()->fc_branch)->count();
        if($check_retur_dtl< 1){
            return [
                'status' => 300,
                'message' => 'Item yang diretur kosong'
            ];
        }
        try {
            DB::beginTransaction();
            TempReturMaster::where('fc_returno', auth()->user()->fc_userid)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                ->update([
                    'fc_returstatus' => 'F',
                    // 'fd_stockopname_end' => Carbon::now()->toDateTimeString() 
                ]);

            TempReturDetail::where('fc_returno', auth()->user()->fc_userid)
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                        ->delete();
            
            TempReturMaster::where('fc_returno', auth()->user()->fc_userid)
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                        ->delete();
                        
            
            DB::commit();

            return [
				'status' => 201, // SUCCESS
                'link' => '/apps/retur-barang',
				'message' => 'Submit berhasil'
			];
        }catch(\Exception $e){
            return [
                'status' => 300,
                'message' => $e->getMessage()
            ];
        }
        // dd($request);
    }

    public function delete_item($fc_barcode, $fn_rownum){
      
        $delete_item =  TempReturDetail::where('fc_returno', auth()->user()->fc_userid)
                    ->where('fn_rownum', $fn_rownum)
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                    ->delete();
        
        $cout_retur_detail = TempReturDetail::where('fc_returno', auth()->user()->fc_userid)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)->count();
            
        if($delete_item){
            if($cout_retur_detail < 2){
                return [
                    'status' => 201,
                    'message' => 'Data berhasil dihapus',
                    'link' => '/apps/retur-barang'
                ];
            }
            return [
                'status' => 200, 
                'message' => 'Item berhasil dihapus'
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Item gagal dihapus'
            ];
        }
           
    }

    
}
