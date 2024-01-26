<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use PDF;
use App\Models\RoMaster;
use App\Models\RoDetail;
use App\Models\SoMaster;
use App\Models\DoMaster;
use App\Models\DoDetail;
use App\Models\InvoiceDtl;
use App\Models\InvoiceMst;
use App\Models\Invstore;
use App\Models\TempInvoiceDtl;
use App\Models\TempInvoiceMst;
use App\Helpers\ApiFormatter;
use App\Models\TransaksiType;
use DB;
use Validator;

class InvoicePembelianDetailController extends Controller
{
    public function create($fc_rono)
    {
        $encoded_fc_rono = base64_decode($fc_rono);
        $data['temp'] = TempInvoiceMst::with('romst', 'pomst', 'bank')->where('fc_invno', auth()->user()->fc_userid)->first();
        $data['ro_mst'] = RoMaster::with('pomst')->where('fc_rono', $encoded_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl'] = RoDetail::with('invstore.stock')->where('fc_rono', $encoded_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->get();
        // $data['ro_mst'] = RoMaster::with('pomst','rodtl','invmst')->where('fc_dono', $encoded_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();

        return view('apps.invoice-pembelian.create', $data);
        // dd($data);
    }

    public function create_multibpb($fc_rono){
        $encoded_fc_rono = base64_decode($fc_rono);
        // $decoded_fc_rono_array = json_decode($encoded_fc_rono, true);
        $data['temp'] = TempInvoiceMst::with('romst', 'pomst', 'bank')->where('fc_invno', auth()->user()->fc_userid)->first();
        $decoded_fc_rono_array = [$encoded_fc_rono];
        if (count($decoded_fc_rono_array) > 0 && is_array($decoded_fc_rono_array)) {
            $values = array_map(function ($jsonString) {
                return json_decode($jsonString, true);
            }, $decoded_fc_rono_array);

            $query = RoMaster::with('pomst.supplier')
                ->where(function ($query) use ($values) {
                    $query->whereIn('fc_rono', array_merge(...$values));
                })
                ->where('fc_branch', auth()->user()->fc_branch);

                $data['ro_mst'] = $query->get();

                $data['ro_dtl'] = RoDetail::with('invstore.stock')
                    ->where(function ($query) use ($values) {
                        $query->whereIn('fc_rono', array_merge(...$values));
                    })
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->get();
        } else {
            $data['ro_mst'] = RoMaster::with('pomst.supplier')
                ->where('fc_rono', $decoded_fc_rono_array[0])
                ->where('fc_branch', auth()->user()->fc_branch)
                ->first();
    
            $data['do_dtl'] = RoDetail::with('invstore.stock')
                ->where('fc_rono', $decoded_fc_rono_array[0])
                ->where('fc_branch', auth()->user()->fc_branch)
                ->get();
        }

        return view('apps.invoice-pembelian.create', $data);
        // dd($data);
        // dd($decoded_fc_dono_array);
    }

    public function insert_item(Request $request)
    {
        $fn_invrownum = 1;
        $tempInvDtl = TempInvoiceDtl::where('fc_invno', auth()->user()->fc_userid)
            ->orderBy('fn_invrownum', 'DESC')
            ->first();

        $total = TempInvoiceDtl::where('fc_invno', auth()->user()->fc_userid)
            ->count();

        // validator data yang dibutuhkan (mandatory)
        if (!empty($request->fc_status)) {
            $validator = Validator::make($request->all(), [
                'fc_detailitem' => 'required',
                'fc_unityname' => 'required',
                'fn_itemqty' => 'required',
                'fm_unityprice' => 'required',
                'fc_status' => 'required'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'fc_detailitem' => 'required',
                'fn_itemqty' => 'required',
                'fm_unityprice' => 'required',
            ]);
        }

        if ($validator->fails()) {
            return [
                'status' => 300,
                'total' => $total,
                'message' => $validator->errors()->first()
            ];
        }

        // Mencari apakah sudah pernah memasukkan CPRR yang sama
        if (!empty($request->fc_status)) {
            $item = TempInvoiceDtl::where([
                'fc_invno' => auth()->user()->fc_userid,
                'fc_detailitem' => $request->fc_detailitem
            ])->first();
        } else {
            $item = TempInvoiceDtl::where([
                'fc_invno' => auth()->user()->fc_userid,
                'fc_detailitem' => $request->fc_detailitem
            ])->first();
        }

        // Kondisi ketika ada CPRR yang sama
        if (!empty($item)) {
            return [
                'status' => 300,
                'total' => $total,
                'message' => 'Produk yang sama telah diinputkan'
            ];
        }

        if (!empty($tempInvDtl)) {
            $fn_invrownum = $tempInvDtl->fn_invrownum + 1;
        }

        if (!empty($request->fc_status)) {
            $request->merge(['fm_unityprice' => Convert::convert_to_double($request->fm_unityprice)]);

            $insert_invdtl = TempInvoiceDtl::create([
                'fn_invrownum' => $fn_invrownum,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_invno' => auth()->user()->fc_userid,
                'fc_status' => $request->fc_status,
                'fc_detailitem' => $request->fc_detailitem,
                'fc_unityname' => $request->fc_unityname,
                'fm_unityprice' => $request->fm_unityprice,
                'fc_invtype' => 'PURCHASE',
                'fn_itemqty' =>  $request->fn_itemqty,
                'fv_description' => ($request->fv_description === '') ? NULL : $request->fv_description
            ]);
        } else {
            $request->merge(['fm_unityprice' => Convert::convert_to_double($request->fm_unityprice)]);

            $insert_invdtl = TempInvoiceDtl::create([
                'fn_invrownum' => $fn_invrownum,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_invno' => auth()->user()->fc_userid,
                'fc_detailitem' => $request->fc_detailitem,
                'fc_unityname' => "CPRR",
                'fm_unityprice' => $request->fm_unityprice,
                'fn_itemqty' =>  $request->fn_itemqty,
                'fv_description' => ($request->fv_description === '') ? NULL : $request->fv_description
            ]);
        }

        if ($insert_invdtl) {
            return response()->json([
                'status' => 200,
                'total' => $total,
                'link' => '/apps/invoice-pembelian',
                'message' => 'Data berhasil disimpan'
            ]);
        } else {
            return [
                'status' => 300,
                'message' => 'Error'
            ];
        }
    }

    public function update_inform($fc_invno, Request $request)
    {

        $temp_inv_master = TempInvoiceMst::where('fc_invno', $fc_invno)
        ->where('fc_invtype', 'PURCHASE');
        $update_tempinvmst = $temp_inv_master->update([
            'fv_description' => $request->fv_description_mst,
            'fc_address' => $request->fc_address,
            'fc_bankcode' => $request->fc_bankcode,
        ]);

        // $temp_inv_master = TempInvoiceMst::with('pomst', 'romst')->where('fc_invno', auth()->user()->fc_userid)->first();
        // $data = [];
        // if (!empty($temp_inv_master)) {
        //     $data['data'] = $temp_inv_master;
        // }

        if ($update_tempinvmst) {
            return [
                'status' => 201,
                // 'data' => $data,
                'message' => 'Data berhasil disimpan',
                // link
                'link' => '/apps/invoice-pembelian'
            ];
            // dd($request);
        }

        return [
            'status' => 300,
            'message' => 'Error'
        ];
    }


    public function datatables_ro_detail($fc_rono, $fc_warehousecode)
    {
        // $decode_dono = base64_decode($fc_dono);
        $decode_fc_warehousecode = base64_decode($fc_warehousecode);
        $data = TempInvoiceDtl::with('invstore.stock', 'tempinvmst')
            ->where('fc_invno', auth()->user()->fc_userid)
            ->where('fc_status', 'DEFAULT')
            ->where('fc_invtype', "PURCHASE")
            ->where('fc_branch', auth()->user()->fc_branch)
            ->get();

        
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function datatables_biaya_lain()
    {
        $data = TempInvoiceDtl::with('tempinvmst', 'nameunity', 'keterangan')
            ->where('fc_invno', auth()->user()->fc_userid)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_invtype', 'PURCHASE')
            ->where('fc_status', 'ADDON')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function delete($fc_invno, $fn_invrownum)
    {
        $count_invdtl = TempInvoiceDtl::where('fc_invno', $fc_invno)->count();

        $deleteInvDtl = TempInvoiceDtl::where([
            'fc_invno' => $fc_invno,
            'fn_invrownum' => $fn_invrownum,
            'fc_invtype' => 'PURCHASE'
        ])->delete();

        if ($deleteInvDtl) {
            if ($count_invdtl < 2) {
                return [
                    'status' => 201,
                    'message' => 'Data berhasil dihapus',
                    'link' => '/apps/invoice-pembelian'
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

    public function update_unityprice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fm_unityprice' => 'required',
            'fn_invrownum' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $update_unityprice = TempInvoiceDtl::where([
            'fc_invno' => auth()->user()->fc_userid,
            'fn_invrownum' => $request->fn_invrownum,
            'fc_invtype' => 'PURCHASE'
        ])->update([
            'fm_unityprice' => Convert::convert_to_double($request->fm_unityprice)
        ]);

        if ($update_unityprice) {
            return [
                'status' => 200,
                'message' => 'Data berhasil diupdate'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Error'
        ];
    }

    public function update_discprice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fm_discprice' => 'required',
            'fn_invrownum' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->merge(['fm_discprice' => number_format((float)$request->fm_discprice, 2, '.', '')]);
        $request->merge(['fm_discprecen' => number_format((float)$request->fm_discprecen, 2, '.', '')]);
        // dd($request->fm_discprice);
        $update_discprice = TempInvoiceDtl::where([
            'fn_invrownum' => $request->fn_invrownum,
            'fc_invno' => auth()->user()->fc_userid,
            'fc_invtype' => 'PURCHASE'
        ])->update([
            'fm_discprice' => ($request->fm_discprice === '') ? NULL : $request->fm_discprice,
            'fm_discprecen' => ($request->fm_discprecen === '') ? NULL : $request->fm_discprecen
        ]);

        if ($update_discprice) {
            return [
                'status' => 200,
                'message' => 'Data berhasil diupdate'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Error'
        ];
    }

    public function get_detail($fn_invrownum)
    {
        $rownum = base64_decode($fn_invrownum);

        $data = RoDetail::with('invstore', 'stock')
            ->where([
                'fn_rownum' =>  $rownum,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
            ])
            ->first();

        return ApiFormatter::getResponse($data);
    }

    public function cancel_invoice()
    {
        DB::beginTransaction();

        try {
            TempInvoiceMst::where('fc_invno', auth()->user()->fc_userid)
                ->where('fc_branch', auth()->user()->fc_branch)
                ->where('fc_invtype', 'PURCHASE')
                ->delete();
            TempInvoiceDtl::where('fc_invno', auth()->user()->fc_userid)
                ->where('fc_branch', auth()->user()->fc_branch)
                ->where('fc_invtype', 'PURCHASE')
                ->delete();

            DB::commit();

            return [
                'status' => 201, // SUCCESS
                'link' => '/apps/invoice-pembelian',
                'message' => 'Data berhasil dihapus'
            ];
        } catch (\Exception $e) {

            DB::rollback();

            return [
                'status'     => 300, // GAGAL
                'message'       => (env('APP_DEBUG', 'true') == 'true') ? $e->getMessage() : 'Operation error'
            ];
        }
    }


    public function submit_invoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fc_invtype' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
        $check_invdtl = TempInvoiceDtl::where('fc_status', 'DEFAULT')->where('fc_branch', auth()->user()->fc_branch)->count();
        if ($check_invdtl < 1) {
            return [
                'status' => 300,
                'message' => 'Barang terkirim kosong'
            ];
        }
        try {
            DB::beginTransaction();
            TempInvoiceMst::where('fc_invno', auth()->user()->fc_userid)
                ->where('fc_invtype', $request->fc_invtype)
                ->where('fc_branch', auth()->user()->fc_branch)
                ->update([
                    'fc_status' => 'R'
                ]);

            TempInvoiceDtl::where('fc_invno', auth()->user()->fc_userid)
                ->where('fc_branch', auth()->user()->fc_branch)
                ->where('fc_invtype', 'PURCHASE')
                ->delete();
            TempInvoiceMst::where('fc_invno', auth()->user()->fc_userid)
                ->where('fc_branch', auth()->user()->fc_branch)
                ->where('fc_invtype', 'PURCHASE')
                ->delete();

            DB::commit();



            return [
                'status' => 201, // SUCCESS
                'link' => '/apps/invoice-pembelian',
                'message' => 'Data berhasil disubmit'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 300,
                'message' => $e->getMessage()
            ];
        }
        // dd($request);

    }

    
    // view ada di daftar invoice detail buat update desc
    // public function edit_description(Request $request)
    // {
    //     InvoiceMst::where('fc_invno', $request->fc_invno)
    //     ->where('fc_branch', auth()->user()->fc_branch)
    //     ->where('fc_invtype', $request->fc_invtype)
    //     ->update([
    //         'fv_description' => $request->fv_description,
    //     ]);

    //     return [
    //         'status' => 201, // SUCCESS
    //         'message' => 'Catatan berhasil diubah'
    //     ];
    //     // dd($request);
    // }
}
