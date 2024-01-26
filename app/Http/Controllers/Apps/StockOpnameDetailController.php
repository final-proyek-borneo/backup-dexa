<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

use App\Models\StockOpname;
use App\Models\TempStockOpnameDetail;
use App\Models\Warehouse;

use Carbon\Carbon;
use DateTime;
use DB;
use Validator;
use App\Helpers\ApiFormatter;
use App\Models\Invstore;

class StockOpnameDetailController extends Controller
{
    public function datatables()
    {
        $data = TempStockOpnameDetail::with('invstore.stock')->where('fc_stockopname_no', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_satuan(){
        $data = TempStockOpnameDetail::with('invstore.stock')->where('fc_stockopname_no', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatable_inventory($fc_warehousecode)
    {
        // decode fc_warehousecode
        $fc_warehousecode = base64_decode($fc_warehousecode);
        $data = Invstore::with('stock')->where('fc_warehousecode', $fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_persediaan($fc_warehousecode)
    {
        // decode fc_warehousecode
        $fc_warehousecode = base64_decode($fc_warehousecode);
        $data = Invstore::with('stock')->where('fc_warehousecode', $fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function lock_update(Request $request)
    {
        // dd($request);
        if ($request->tipe == 'lock') {
            $data = TempStockOpnameDetail::where('fn_rownum', $request->fn_rownum)
                ->where('fc_stockopname_no', auth()->user()->fc_userid)->update([
                    'fc_status' => 'L',
                    'fn_quantity' => $request->fn_quantity,
                ]);

            if ($data) {
                return [
                    'status' => 200,
                    'message' => 'Data berhasil diupdate'
                ];
            } else {
                return [
                    'status' => 300,
                    'message' => 'Data gagal diupdate'
                ];
            }
        } else {
            $data = TempStockOpnameDetail::where('fn_rownum', $request->fn_rownum)
                ->where('fc_stockopname_no', auth()->user()->fc_userid)->update([
                    'fc_status' => 'U',
                    'fn_quantity' => $request->fn_quantity,
                ]);

            if ($data) {
                return [
                    'status' => 200,
                    'message' => 'Data berhasil diupdate'
                ];
            } else {
                return [
                    'status' => 300,
                    'message' => 'Data gagal diupdate'
                ];
            }
        }

        // 
    }

    public function select_stock(request $request)
    {
        $validator = Validator::make($request->all(), [
            'fc_barcode' => 'required',
            'fn_quantity' => 'required',
        ]);


        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $temp_detail = TempStockOpnameDetail::where('fc_stockopname_no', auth()->user()->fc_userid)->orderBy('fn_rownum', 'DESC')->first();
        // jika ada TempStockOpnameDetail yang fc_barcode == $request->fc_barcode
        $count_barcode = TempStockOpnameDetail::where('fc_stockopname_no', auth()->user()->fc_userid)->where('fc_barcode', $request->fc_barcode)->get();
        if (!empty($temp_detail)) {
            // jika ditemukan $count_stockcode error produk yang sama telah diinputkan
            if (count($count_barcode) > 0) {
                return [
                    'status' => 300,
                    'message' => 'Produk yang sama telah diinputkan'
                ];
            }
        }

        $stockopname_master = StockOpname::with('warehouse')->where('fc_stockopname_no', auth()->user()->fc_userid)->first();
        $temp_stockopname_dtl = TempStockOpnameDetail::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_userid' => auth()->user()->fc_userid,
            'fc_stockopname_no' => auth()->user()->fc_userid,
            'fc_barcode' => $request->fc_barcode,
            'fc_warehousecode' => $stockopname_master->fc_warehousecode,
            'fn_quantity' => $request->fn_quantity,
            'fc_status' => 'L',
        ]);

        if ($temp_stockopname_dtl) {
            return [
                'status' => 200,
                'message' => 'Data berhasil ditambahkan'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Data gagal ditambahkan'
            ];
        }
    }

    public function delete_item($fn_rownum){
        $delete = TempStockOpnameDetail::where('fc_stockopname_no', auth()->user()->fc_userid)
            ->where('fn_rownum', $fn_rownum)
            ->delete();
        
        $count_data = TempStockOpnameDetail::where('fc_stockopname_no', auth()->user()->fc_userid)->count(); 

        if ($delete) {
            if($count_data <= 1){
                return [
                    'status' => 201,
                    'message' => 'Data berhasil dihapus',
                    'link' => '/apps/stock-opname'
                ];
            }
            return [
                'status' => 200,
                'message' => 'Data berhasil dihapus'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Data gagal dihapus'
            ];
        }
    }

    public function submit_stockopname(Request $request){
        try {
            DB::beginTransaction();
            StockOpname::where('fc_stockopname_no', auth()->user()->fc_userid)
                                                ->where('fc_branch', auth()->user()->fc_branch)->update([
                                                 'fc_stockopname_status' => 'F',
                                                 'fd_stockopname_end' => Carbon::now()->toDateTimeString()
                                                ]);
            TempStockOpnameDetail::where('fc_stockopname_no', auth()->user()->fc_userid)
                                                ->where('fc_branch', auth()->user()->fc_branch)->delete();
            DB::commit();
            return [
				'status' => 201, // SUCCESS
                'link' => '/apps/stock-opname',
				'message' => 'Submit berhasil'
			];
        } catch (\Exception $e) {
            return [
                'status' => 300,
                'message' => $e->getMessage()
            ];
        }
    }
}
