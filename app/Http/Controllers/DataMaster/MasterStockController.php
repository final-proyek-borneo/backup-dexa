<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Convert;
use App\Helpers\NoDocument;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\Stock;

class MasterStockController extends Controller
{
    public function index(){
        return view('data-master.master-stock.index');
    }

    public function detail($fc_stockcode, $fc_barcode){
        $stockcodeDecode = base64_decode($fc_stockcode);
        $barcodeDecode = base64_decode($fc_barcode);
        return Stock::where([
            'fc_stockcode' => $stockcodeDecode,
            'fc_barcode' => $barcodeDecode,
        ])->where('fc_branch', auth()->user()->fc_branch)->first();
        // dd($fc_barcode);
    }

    public function datatables(){
        $data = Stock::with(
            'branch',
            'namepack',
            'type_stock1',
            'type_stock2',
        )->where('fc_branch', auth()->user()->fc_branch)->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
       $validator = Validator::make($request->all(), [
            'fc_stockcode' => 'required',
            'fc_barcode' => 'required',
        ]);

    //     if($validator->fails()) {
    //         return [
    //             'status' => 300,
    //             'message' => $validator->errors()->first()
    //         ];
    //     }

        $request->request->add(['fc_branch' => auth()->user()->fc_branch]);
        if(empty($request->type)){
            $cek_data = Stock::where([
                'fc_stockcode' => $request->fc_stockcode,
                'deleted_at' => null,
            ])->withTrashed()->count();

            if($cek_data > 0){
                return [
                    'status' => 300,
                    'message' => 'Oops! Insert gagal karena data sudah ditemukan didalam sistem kami'
                ];
            }
        }

        // cek exist data
        // $exist_data = Stock::where('fc_stockcode' , $request->fc_stockcode)
        // ->where('fc_branch', auth()->user()->fc_branch)->count();
        
        // // jika exist data lebih besar dari 0
        // if($exist_data > 0){
        //     return [
        //         'status' => 300,
        //         'message' => 'Oops! Insert gagal karena data sudah ditemukan didalam sistem kami'
        //     ];
        // }
            
        $request->merge(['fn_reorderlevel' => Convert::convert_to_double($request->fn_reorderlevel) ]);
        $request->merge(['fn_maxonhand' => Convert::convert_to_double($request->fn_maxonhand) ]);
        $request->merge(['fm_cogs' => Convert::convert_to_double($request->fm_cogs) ]);
        $request->merge(['fm_purchase' => Convert::convert_to_double($request->fm_purchase) ]);
        $request->merge(['fm_salesprice' => Convert::convert_to_double($request->fm_salesprice) ]);

        $request->merge(['fm_purchase' => Convert::convert_to_double($request->fm_purchase) ]);
        $request->merge(['fm_salesprice' => Convert::convert_to_double($request->fm_salesprice) ]);
        $request->merge(['fm_disc_pr' => Convert::convert_to_double($request->fm_disc_pr) ]);
        $request->merge(['fm_disc_rp' => Convert::convert_to_double($request->fm_disc_rp) ]);
        $request->merge(['fm_time_disc_rp' => Convert::convert_to_double($request->fm_time_disc_rp) ]);
        $request->merge(['fm_time_disc_pr' => Convert::convert_to_double($request->fm_time_disc_pr) ]);
        $request->merge(['fm_price_distributor' => Convert::convert_to_double($request->fm_price_distributor) ]);
        $request->merge(['fm_price_project' => Convert::convert_to_double($request->fm_price_project) ]);
        $request->merge(['fm_price_dealer' => Convert::convert_to_double($request->fm_price_dealer) ]);
        $request->merge(['fm_price_enduser' => Convert::convert_to_double($request->fm_price_enduser) ]);
        $request->merge(['fm_price_default' => Convert::convert_to_double($request->fm_price_default) ]);

        Stock::updateOrCreate([
            'fc_stockcode' => $request->fc_stockcode,
            'fc_barcode' => $request->fc_barcode,
        ], $request->all());

		return [
			'status' => 200, // SUCCESS
			'message' => 'Data berhasil disimpan'
		];
    }

    public function delete($fc_stockcode, $fc_barcode){
        Stock::where([
            'fc_stockcode' => $fc_stockcode,
            'fc_barcode' => $fc_barcode,
        ])->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }

    public function hold(Request $request, $fc_barcode){
        // ubah fc_sostatus yang fc_sono sama dengan $request->fc_sono

        $decode_fc_barcode = base64_decode($fc_barcode);

        $fc_barcode = $decode_fc_barcode;
        $fc_hold = $request->fc_hold;

        // update
        $stock = Stock::where('fc_barcode', $fc_barcode)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $stock->update([
            'fc_hold' => $fc_hold,
        ]);


        if ($update_status) {
            return [
                'status' => 200,
                'message' => 'Data berhasil di hold',
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data gagal di hold'
        ];
    }

    public function unhold(Request $request, $fc_barcode){
        // ubah fc_sostatus yang fc_sono sama dengan $request->fc_sono

        $decode_fc_barcode = base64_decode($fc_barcode);

        $fc_barcode = $decode_fc_barcode;
        $fc_hold = $request->fc_hold;

        // update
        $stock = Stock::where('fc_barcode', $fc_barcode)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $stock->update([
            'fc_hold' => $fc_hold,
        ]);


        if ($update_status) {
            return [
                'status' => 200,
                'message' => 'Data berhasil di unhold',
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data gagal di unhold'
        ];
    }
}
