<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;

use App\Helpers\Convert;
use Carbon\Carbon;
use File;

use App\Models\TempSoMaster;
use App\Models\TempSoDetail;
use App\Models\Customer;
use App\Models\Stock;
use App\Models\Invstore;
use App\Models\TempSoPay;
use App\Models\Warehouse;
use Yajra\DataTables\DataTables;

class SalesOrderDetailController extends Controller
{
    public function datatables()
    {
        $data = TempSoDetail::with('branch', 'warehouse', 'stock', 'namepack','tempsomst')
        ->where('fc_sono', auth()->user()->fc_userid)
        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->get();

        $nominal = TempSoPay::where('fc_sono', auth()->user()->fc_userid)
        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->sum('fm_valuepayment');

        return DataTables::of($data)
            ->addColumn('total_harga', function ($item) {
                return $item->fn_so_qty * $item->fm_so_oriprice;
            })->addColumn('nominal', function () use($nominal){
                return $nominal;
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_inventory()
    {
        ini_set('memory_limit', '2048M'); // 2GB
        set_time_limit(360);
        $data = Invstore::with('stock', 'warehouse')
        ->whereHas('warehouse', function($query){
            $query->where('fc_warehousepos', '=', 'INTERNAL');
        })
        ->where('fc_branch', auth()->user()->fc_branch)
        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
        ->get();

        // $data = Invstore::with('stock')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function save_catatan(Request $request){
        $data = TempSoMaster::where('fc_sono', auth()->user()->fc_userid)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
        ->first();
        $data->fv_description = $request->fv_description_mst;
        $data->save();

        // jika data berhasil di save
        if($data){
            return response()->json([
                'status' => 201,
                'message' => 'Data berhasil di simpan',
                'link' => '/apps/sales-order'
            ]);
        }else{
            return response()->json([
                'status' => 300,
                'message' => 'Data gagal di simpan'
            ]);
        }
    }

    public function store_update(request $request){
        $count_sodtl = TempSoDetail::where('fc_sono', auth()->user()->fc_userid)
        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->get();
        $total = count($count_sodtl);
        $validator = Validator::make($request->all(), [
            'fc_stockcode' => 'required',
            'fc_barcode' => 'required',
            'fn_so_qty' => 'required|integer|min:1',
            'fn_so_bonusqty' => 'nullable|integer|min:0',
        ], [
            'fc_stockcode.required' => 'Kode Barang harus diisi',
            'fn_so_qty.required' => 'Quantity harus diisi',
        ]);

        if ($validator->fails()) {
            // dd($validator->errors()->first());
            return [
                'status' => 300,
                'total' => $total,
                'message' => $validator->errors()->first()
            ];
        }

        $stock = Stock::where(['fc_stockcode' => $request->fc_stockcode])->first();

        $temp_detail = TempSoDetail::where('fc_sono', auth()->user()->fc_userid)->orderBy('fn_sorownum', 'DESC')->first();

        // jika ada TempSoDetail yang fc_stockcode == $request->fc_stockcode
        $count_stockcode = TempSoDetail::where('fc_sono', auth()->user()->fc_userid)->where('fc_stockcode', $request->fc_stockcode)->get();
        

         
        
        // jika ada fc_stockcode yang sama di $temp_detail 
        if (!empty($temp_detail)) {
            // jika ditemukan $count_stockcode error produk yang sama telah diinputkan
            if (count($count_stockcode) > 0) {
                return [
                    'status' => 300,
                    'total' => $total,
                    'message' => 'Produk yang sama telah diinputkan'
                ];
            }
        }


        $fn_sorownum = 1;
        if (!empty($temp_detail)) {
            $fn_sorownum = $temp_detail->fn_sorownum + 1;
        }

        $stock = Stock::where('fc_stockcode', $request->fc_stockcode)->first();

        //total harga
        $total_harga = $request->fn_so_value * $request->fm_so_price;

        $request->merge(['fn_so_qty' => Convert::convert_to_double($request->fn_so_qty)]);
        $request->merge(['fn_so_bonusqty' => Convert::convert_to_double($request->fn_so_bonusqty)]);
        $request->merge(['fn_so_value' => Convert::convert_to_double($total_harga)]);
        $request->merge(['fm_so_price' => Convert::convert_to_double($stock->fm_price_default)]);
        $request->merge(['fm_so_price_edit' => Convert::convert_to_double($request->fm_so_price_edit)]);

        $insert_so_detail = TempSoDetail::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_sono' => auth()->user()->fc_userid,
            'fn_sorownum' => $fn_sorownum,
            'fc_stockcode' => $stock->fc_stockcode,
            'fc_barcode' => $request->fc_barcode,
            'fc_namepack' => $stock->fc_namepack,
            'fn_so_qty' => $request->fn_so_qty,
            'fn_so_bonusqty' => $request->fn_so_bonusqty,
            'fn_so_value' => $request->fn_so_qty * $request->fm_so_price_edit,
            'fm_so_oriprice' => $request->fm_so_price,
            'fm_so_price' => $request->fm_so_price_edit,
            'fv_description' => $request->fv_description
        ]);

    //    dd($request); 

        // dd($request->fn_so_qty*$request->fm_so_price);

        // dd(Convert::convert_to_double($total_harga));




        // $so_discount = 0;
        // $so_total = 0;
        // $so_grand = 0;

        // if(!empty($temp_detail)){
        //     foreach($temp_detail as $item){
        //         $so_discount += $item->fm_so_disc;
        //         $so_total += $item->fm_so_price * $item->fn_so_qty;
        //     }

        //     $so_grand = $so_total - $so_discount;
        // }

        // $data['discount'] = $so_discount;
        // $data['total'] = $so_total;
        // $data['grand'] = $so_grand;

        // $data['discount_view'] = "Rp " . number_format($so_discount,0,',','.');
        // $data['total_view'] = "Rp " . number_format($so_total,0,',','.');
        // $data['grand_view'] = "Rp " . number_format($so_grand,0,',','.');
            
        if($insert_so_detail){
            return response()->json([
               'status' => 200,
               'total' => $total,
               'link' => '/apps/sales-order',
               'message' => 'Data berhasil disimpan'
           ]);
        } else{
            return [
                'status' => 300,
                'link' => '/apps/sales-order',
                'message' => 'Error'
            ];
        }
    }

    public function delete($fc_sono, $fn_sorownum)
    {
        // hitung jumlah TempSoDetail
        $count_sodtl = TempSoDetail::where('fc_sono', $fc_sono)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
        ->count();
        $insert_tempsodetail = TempSoDetail::where(['fc_sono' => $fc_sono, 'fn_sorownum' => $fn_sorownum])->delete();

        if($insert_tempsodetail){
            if($count_sodtl < 2){
                return [
                    'status' => 201,
                    'message' => 'Data berhasil dihapus',
                    'link' => '/apps/sales-order'
                ];
            }
            return [
                'status' => 200,
                'message' => 'Data berhasil dihapus',
            ];
        }
        return [
            'status' => 300,
            'message' => 'Error',
        ];
    }

    public function lock()
    {

        try {
            // TempSoMaster::where(['fc_sono' => auth()->user()->fc_userid, 'fc_sostatus' => 'I'])->update(['fc_sostatus' => 'F']);

            $temp_detail = TempSoDetail::where('fc_sono', auth()->user()->fc_userid)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->get();
            $total = count($temp_detail);


            if ($total != 0) {
                TempSoMaster::where(['fc_sono' => auth()->user()->fc_userid, 'fc_sostatus' => 'I'])->update(['fc_sostatus' => 'F', 'fn_sodetail' => $total]);
                return [
                    'status' => 201,
                    'message' => 'Data berhasil di lock'
                ];
            } else {
                return [
                    'status' => 300,
                    'message' => 'Item pesanan masih kosong, silahkan masukkan pesanan Anda!'
                ];
            }
        } catch (\Illuminate\Database\QueryException $e) {

            return [
                'status' => 300,
                'message' => 'Data gagal di lock silahkan coba lagi'
            ];
        }
    }

  
}
