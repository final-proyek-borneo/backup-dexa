<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use App\Models\InvDetail;
use App\Models\InvMaster;
use App\Models\RoDetail;
use App\Models\RoMaster;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class MasterInvoiceDetailController extends Controller
{
    public function create($fc_rono)
    {
        $decode_fc_rono = base64_decode($fc_rono);
        $data['ro_mst'] = RoMaster::with('pomst.supplier.supplier_tax_code')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['tipe_cabang'] = RoMaster::with('pomst.supplier.supplier_typebranch')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['tipe_bisnis'] = RoMaster::with('pomst.supplier.supplier_type_business')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['legal_status'] = RoMaster::with('pomst.supplier.supplier_legal_status')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['inv_mst'] = InvMaster::where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();

        // jika ada InvMaster dimana 'fc_rono' sama dengan $fc_rono
        $count_inv_mst = InvMaster::where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->count();

        if ($count_inv_mst === 0) {
            return view('apps.master-invoice.create-index', $data);
        }
         return view('apps.master-invoice.create-detail', $data);       
        // dd($data);
    }

    // incoming_insert
    public function incoming_insert(Request $request){
        $validator = Validator::make($request->all(), [
            'fc_pono' => 'required',
            'fc_rono' => 'required',
            'fc_userid' => 'required',
            'fd_inv_releasedate' => 'required',
            'fd_inv_agingdate' => 'required',
        ],
        [
            'fc_pono.required' => 'Purchase Order Number is required',
            'fc_rono.required' => 'Receiving Order Number is required',
            'fc_userid.required' => 'User ID is required',
            'fd_inv_releasedate.required' => 'Release Date is required',
            'fd_inv_agingdate.required' => 'Aging Date is required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        // fc_inv_agingday = $request->fd_inv_agingdate - $request->fd_inv_releasedate, konvert jumlah harinya
        $invAgingDate = Carbon::parse($request->fd_inv_agingdate);
        $invReleaseDate = Carbon::parse($request->fd_inv_releasedate);
        $fn_inv_agingday = $invAgingDate->diffInDays($invReleaseDate);
    
        // insert into inv master
        $insert_inv_mst = InvMaster::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_invno' => auth()->user()->fc_userid,
            'fc_pono' => $request->fc_pono,
            'fc_rono' => $request->fc_rono,
            'fc_userid' => $request->fc_userid,
            'fd_inv_releasedate' => $request->fd_inv_releasedate,
            'fd_inv_agingdate' => $request->fd_inv_agingdate,
            'fc_status' => 'I',
            'fc_invtype' => 'INC',
            'fn_inv_agingday' => $fn_inv_agingday,
            'fn_invdetail' => $request->fn_rodetail
        ]);

        if($insert_inv_mst){
            return [
                'status' => 201,
                'message' => 'Buat Invoice berhasil',
                'link' => '/apps/master-invoice/create/'. base64_encode($request->fc_rono)
            ];
        }

        return [
            'status' => 300,
            'message' => 'Gagal buat Invoice'
        ];

    }

    public function datatables_ro($fc_rono)
    {
        $decode_fc_rono = base64_decode($fc_rono);
        $data = RoDetail::with('invstore.stock', 'romst.invmst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function delete_inv($fc_invno){

        $decode_fc_invno = base64_decode($fc_invno);
        DB::beginTransaction();
        try{
            RoDetail::where('fc_rono', InvMaster::where('fc_invno', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->first()->fc_rono)->update([
                'fn_price' => 0,
                'fn_disc' => 0
            ]);
            InvMaster::where('fc_invno', $decode_fc_invno)->where('fc_branch', auth()->user()->fc_branch)->delete();
            // InvDetail::where('fc_invno', $fc_invno)->where('fc_branch', auth()->user()->fc_branch)->delete();

            DB::commit();
            return [
                'status' => 201,
                'message' => 'Hapus Invoice berhasil',
                'link' => '/apps/master-invoice'
            ];
        }catch(\Exception $e){

			DB::rollback();

			return [
				'status' 	=> 300, // GAGAL
				'message'       => (env('APP_DEBUG', 'true') == 'true')? $e->getMessage() : 'Operation error'
			];

		}
    }

    public function incoming_edit_ro(Request $request){
        // validator
        $validator = Validator::make($request->all(), [
            'fc_rono' => 'required',
            'fn_rownum' => 'required',
            'fc_stockcode' => 'required',
            'fn_price' => 'required',
            'fn_disc' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        // update rodetail
        $update_rodetail = RoDetail::where('fc_rono', $request->fc_rono)->where('fc_branch', auth()->user()->fc_branch)->where('fn_rownum', $request->fn_rownum)->update([
            'fn_price' => $request->fn_price,
            'fn_disc' => $request->fn_disc,
        ]);

        if($update_rodetail){
            return [
                'status' => 200,
                'message' => 'Update Item Receiving berhasil berhasil',
            ];
        }

        return [
            'status' => 300,
            'message' => 'Gagal update RO Detail'
        ];
    }

    public function delivery_update(Request $request){

        $validator = Validator::make($request->all(), [
            'fm_servpay' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
        $update_inv_mst = InvMaster::where('fc_branch', auth()->user()->fc_branch)->where('fc_status', 'I')->where('fc_invno', $request->fc_invno)->update([
            'fm_servpay' => $request->fm_servpay,
        ]);

        if($update_inv_mst){
            return [
                'status' => 201,
                'message' => 'Data berhasil disimpan',
                'link' => '/apps/master-invoice/create/'. base64_encode($request->fc_rono)
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data gagal disimpan'
        ];
    }


    public function submit_invoice(Request $request){
        $validator = Validator::make($request->all(), [
            'fc_invno' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        // update inv master
        $update_inv_mst = InvMaster::where('fc_branch', auth()->user()->fc_branch)->where('fc_status', 'I')->where('fc_invno', $request->fc_invno)->update([
            'fc_status' => 'R',
        ]);

        if($update_inv_mst){
            return [
                'status' => 201,
                'message' => 'Data Invoice berhasil disubmit',
                'link' => '/apps/master-invoice'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data gagal disimpan'
        ];
    }


}
