<?php

namespace App\Http\Controllers\apps;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Invstore;
use App\Models\Stock;
use App\Models\StockInquiri;
use Carbon\Carbon;
use DB;
use Facade\FlareClient\Api;
use Illuminate\Http\Request;
use Str;
use Validator;
use Whoops\Exception\Formatter;
use Yajra\DataTables\Facades\DataTables;

class StockKonversiController extends Controller
{
    public function index(){
        return view('apps.konversi-stock.index');
    }
    
    public function konversi(request $request){
        $validator = Validator::make($request->all(), [
            'fc_barcode' => 'required',
            'fc_warehousecode' => 'required',
            'fc_stockcode' => 'required',
            'fn_quantity' => 'required',
            'fn_scale1' => 'required',
            'fn_scale2' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $currentQty = $request->fn_quantity;
        $scaleCalculation = $request->fn_scale2 / $request->fn_scale1;
        $qtyinquiri = $currentQty  * $scaleCalculation;
        
        // dd($request);
        DB::beginTransaction();

        try {
            // Ambil data stok yang akan diconvert 
            $barcodeToConvert = Invstore::with('stock.namepack')->where([
                'fc_warehousecode' => $request->fc_warehousecode,
                'fc_barcode' => $request->fc_barcode,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch
            ])
            ->first();
            

            if(!empty($request->barcode_result_convert) || $request->barcode_result_convert != null){
                // Ambil data stok tujuan konversi 
                $barcodeConvertResult = Invstore::with('stock.namepack')->where([
                    'fc_warehousecode' => $request->fc_warehousecode,
                    'fc_barcode' => $request->barcode_result_convert,
                    'fc_divisioncode' => auth()->user()->fc_divisioncode,
                    'fc_branch' => auth()->user()->fc_branch
                ])
                ->first();
                
                $stockNameResult = $barcodeConvertResult->stock->fc_namelong;
                $stockPackResult = $barcodeConvertResult->stock->fc_namepack;
                // Insert terkait penambahan qty dari Konversi
                StockInquiri::create([
                    'fc_divisioncode' => auth()->user()->fc_divisioncode,
                    'fc_branch' => auth()->user()->fc_branch,
                    'fc_barcode' => $barcodeConvertResult->fc_barcode,
                    'fc_warehousecode' => $request->fc_warehousecode,
                    'fn_out' => 0,
                    'fn_in' => $qtyinquiri,
                    'fn_balance' => $barcodeConvertResult->fn_quantity +  $qtyinquiri,
                    'fd_inqdate' => Carbon::now(),
                    'fc_docreference' => 'KONVERSI',
                    'fv_description' => "Hasil konversi dari "  . $currentQty .  " " .
                                        $barcodeToConvert->stock->namepack->fv_description . " " .
                                        $barcodeToConvert->stock->fc_namelong . " Menjadi " . $qtyinquiri . " " . 
                                        $barcodeConvertResult->stock->namepack->fv_description . " " .
                                        $barcodeConvertResult->stock->fc_namelong,
                    'fc_userid' => auth()->user()->fc_userid
                ]);

                // update stok setelah ditambah hasil konversi 
                $barcodeConvertResult->update([
                    'fn_quantity' => $barcodeConvertResult->fn_quantity + $qtyinquiri
                ]);

            } else {
                // informasi stok tujuan diambil dari data stok 
                $barcodeConvertResult = Stock::with('namepack')
                ->where([
                    'fc_stockcode' => $request->fc_stockcode,
                    'fc_divisioncode' => auth()->user()->fc_divisioncode,
                    'fc_branch' => auth()->user()->fc_branch
                ])
                ->first();

                $stockNameResult = $barcodeConvertResult->fc_namelong;
                $stockPackResult = $barcodeConvertResult->fc_namepack;
                $halfCode = substr($request->fc_barcode,40);
                $newBarcode = $barcodeConvertResult->fc_barcode . $halfCode;
                
                Invstore::create([
                    'fc_divisioncode' => auth()->user()->fc_divisioncode,
                    'fc_branch' => auth()->user()->fc_branch,
                    'fc_warehousecode' => $request->fc_warehousecode,
                    'fl_status' => 'GD',
                    'fn_quantity' => $qtyinquiri,
                    'fc_barcode' => $newBarcode,
                    'fc_stockcode' => $request->fc_stockcode,
                    'fc_batch' => $barcodeToConvert->fc_batch,
                    'fd_expired' => $barcodeToConvert->fd_expired,
                    'fc_catnumber' => $barcodeToConvert->fc_catnumber,
                    'fm_hpp' => $barcodeToConvert->fm_hpp,
                    'fm_cogs' => $barcodeToConvert->fm_cogs,
                    'fm_purchase' => $barcodeToConvert->fm_purchase
                ]);

                StockInquiri::create([
                    'fc_divisioncode' => auth()->user()->fc_divisioncode,
                    'fc_branch' => auth()->user()->fc_branch,
                    'fc_barcode' => $newBarcode,
                    'fc_warehousecode' => $request->fc_warehousecode,
                    'fn_out' => 0,
                    'fn_in' => $qtyinquiri,
                    'fn_balance' =>  $qtyinquiri,
                    'fd_inqdate' => Carbon::now(),
                    'fc_docreference' => 'KONVERSI',
                    'fv_description' => "Hasil konversi dari "  . $currentQty .  " " .
                                        $barcodeToConvert->stock->namepack->fv_description .
                                        " Menjadi " . $qtyinquiri . " " . 
                                        $barcodeConvertResult->namepack->fv_description . 
                                        " " . $barcodeConvertResult->fc_namelong,
                    'fc_userid' => auth()->user()->fc_userid
                ]);
            }

            // Insert stock inquiri terkait pengurangan stok 
            StockInquiri::create([
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_barcode' => $request->fc_barcode,
                'fc_warehousecode' => $request->fc_warehousecode,
                'fn_out' => $currentQty,
                'fn_in' => 0,
                'fn_balance' => $barcodeToConvert->fn_quantity - $currentQty,
                'fd_inqdate' => Carbon::now(),
                'fc_docreference' => 'KONVERSI',
                'fv_description' => "Konversi sejumlah "  . $currentQty .  " " .
                                    $barcodeToConvert->stock->namepack->fv_description .
                                    " Menjadi " .$qtyinquiri . " " . $stockPackResult .
                                    " " . $stockNameResult,
                'fc_userid' => auth()->user()->fc_userid
            ]);

            // mengurangi stok pada invstore asal 
            $barcodeToConvert->update([
                'fn_quantity' => $barcodeToConvert->fn_quantity - $currentQty
            ]);

            DB::commit();

            return [
				'status' => 201, // SUCCESS
                'link' => '/apps/konversi-stock',
				'message' => 'Barang berhasil dikonversi'
			];
        } catch (\Exception $e) {
            DB::rollback();

			return [
				'status' 	=> 300, // GAGAL
				'message'       => (env('APP_DEBUG', 'true') == 'true')? $e->getMessage() : 'Operation error'
			];
        }

    }

    public function datatable_inquiry(){
        ini_set('memory_limit', '2048M'); // 2GB
        set_time_limit(360);
        $data = StockInquiri::with('invstore.stock','warehouse')
        ->where([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_docreference' =>  'KONVERSI'
        ])
        ->orderBy('id','DESC')
        ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make();
    }

    public function stock_stockcode ($fc_stockcode){
        $stockcode = base64_decode($fc_stockcode);
        
        $data = Stock::where([
            'fc_stockcode' =>  $stockcode,
            'fc_branch' => auth()->user()->fc_branch
        ])
        ->first();
        
        if(!empty($data)){
            return ApiFormatter::getResponse($data);
        } else {
            return [
                'status' => 300,
                'data' => 'Barang Tidak Ditemukan'
            ];
        }
    }

    public function invstore_stockcode($fc_stockcode, $fc_warehousecode, $fd_expired, $fc_batch){
        $stockcode = base64_decode($fc_stockcode);
        $warehousecode = base64_decode($fc_warehousecode);
        $expired = base64_decode($fd_expired);
        $batch = base64_decode($fc_batch);
        
        $data = Invstore::with('stock')
        ->where('fc_stockcode', $stockcode)
        ->where('fc_warehousecode', $warehousecode)
        ->where('fd_expired', $expired)
        ->where('fc_batch', $batch)
        ->first();

        if(!empty($data)){
            return ApiFormatter::getResponse($data);
        } else {
            return [
                'status' => 300,
                'data' => 'Barang Tidak Ditemukan'
            ];
        }
    }

    public function invstore_warehouse($fc_warehousecode){
        ini_set('memory_limit', '2048M'); // 2GB
        set_time_limit(360);
        $warehousecode = base64_decode($fc_warehousecode);

        $data = Invstore::with('stock', 'warehouse')
        ->where([
            'fc_warehousecode' => $warehousecode,
            'fc_branch' => auth()->user()->fc_branch,
        ])
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
