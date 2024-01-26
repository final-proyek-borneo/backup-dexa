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

class StockOpnameController extends Controller
{
    public function index()
    {
        $stockopname_master = StockOpname::with('warehouse')->where('fc_stockopname_no', auth()->user()->fc_userid)->first();
        $temp_stockopname_detail = TempStockOpnameDetail::where('fc_stockopname_no', auth()->user()->fc_userid)->get();

        $total = count($temp_stockopname_detail);
        if (!empty($stockopname_master)) {
            if ($stockopname_master->fc_warehousecode == 'ALLDEXA') {
                $jumlah_stock = Invstore::all()->where('fc_branch', auth()->user()->fc_branch)->count();
                $stock_teropname = TempStockOpnameDetail::where('fc_stockopname_no', auth()->user()->fc_userid)
                    ->where('fc_status', 'L')
                    ->where('fc_branch', auth()->user()->fc_branch)->count();
                $data['jumlah_stock'] = $jumlah_stock;
                $data['stock_teropname'] = $stock_teropname;
            } else {
                $jumlah_stock = Invstore::where('fc_warehousecode', $stockopname_master->fc_warehousecode)
                    ->where('fc_branch', auth()->user()->fc_branch)->count();
                $stock_teropname = TempStockOpnameDetail::where('fc_stockopname_no', auth()->user()->fc_userid)
                    ->where('fc_status', 'L')
                    ->where('fc_branch', auth()->user()->fc_branch)->count();
                $data['jumlah_stock'] = $jumlah_stock;
                $data['stock_teropname'] = $stock_teropname;
            }
            $data['data'] = $stockopname_master;
            $data['total'] = $total;

            return view('apps.stock-opname.detail', $data);
        }
        return view('apps.stock-opname.index');
    }

    public function detail_gudang($fc_warehousecode)
    {

        $fc_warehousecode = base64_decode($fc_warehousecode);
        $data = Warehouse::where('fc_warehousecode', $fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->first();
        // retur json
        return response()->json(
            [
                'data' => $data,
                'status' => 'success'
            ]
        );
    }

    public function store_update(Request $request)
    {
        // validator
        $validator = Validator::make($request->all(), [
            'fc_warehousecode' => 'required',
            'fd_stockopname_start' => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $stockopname_mst = StockOpname::where('fc_stockopname_no', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->first();

        if (empty($stockopname_mst)) {
            // create TempInvoiceMst
            $insert = StockOpname::create([
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_stockopname_no' => auth()->user()->fc_userid,
                'fc_warehousecode' => $request->fc_warehousecode,
                'fc_stockopname_type' => $request->fc_stockopname_type,
                'fc_stockopname_status' => 'I',
                'fd_stockopname_start' => date('Y-m-d H:i:s', strtotime($request->fd_stockopname_start)),
                'fc_userid' => auth()->user()->fc_userid,
            ]);

            if ($insert) {
                return [
                    'status' => 201,
                    'message' => 'Data berhasil disimpan',
                    'link' => '/apps/stock-opname'
                ];
            } else {
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];
            }
        } else {
            return [
                'status' => 300,
                'message' => 'Data sudah ada'
            ];
        }
    }

    public function cancel()
    {
        DB::beginTransaction();

        try {
            TempStockOpnameDetail::where('fc_stockopname_no', auth()->user()->fc_userid)->delete();
            StockOpname::where('fc_stockopname_no', auth()->user()->fc_userid)->delete();


            DB::commit();

            return [
                'status' => 201, // SUCCESS
                'link' => '/apps/stock-opname',
                'message' => 'Stock Opname berhasil di Cancel'
            ];
        } catch (\Exception $e) {

            DB::rollback();

            return [
                'status'     => 300, // GAGAL
                'message'       => (env('APP_DEBUG', 'true') == 'true') ? $e->getMessage() : 'Operation error'
            ];
        }
    }
}
