<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\MappingDetail;
use App\Models\MappingMaster;
use App\Models\TransaksiType;
use Carbon\Carbon;
use DB;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Helpers\ApiFormatter;

class MasterMappingController extends Controller
{

    public function index()
    {
        $mapping_mst = MappingMaster::where('created_by', auth()->user()->fc_userid)
            ->where('fc_status', 'I')
            ->where('fc_branch', auth()->user()->fc_branch)->first();
        $cek_exist = MappingMaster::where('created_by', auth()->user()->fc_userid)
            ->where('fc_status', 'I')
            ->where('fc_branch', auth()->user()->fc_branch)->count();
        if ($cek_exist > 0) {
            $fc_mappingcode = $mapping_mst->fc_mappingcode;
            $data['fc_credit_previledge'] = json_decode($mapping_mst->fc_credit_previledge);
            $data['fc_debit_previledge'] = json_decode($mapping_mst->fc_debit_previledge);
            $data['data'] = MappingMaster::where('fc_branch', auth()->user()->fc_branch)->where('fc_mappingcode', $fc_mappingcode)->first();
            $data['trxaccmethod'] = TransaksiType::where('fc_trx', 'TRXACCMETHOD')->get();
            return view('apps.master-mapping.create', $data);
            // dd($data);
        }

        return view('apps.master-mapping.index');
    }

    public function detail($fc_mappingcode)
    {
        $decode_fc_mappingcode = base64_decode($fc_mappingcode);
        $mappingMaster = MappingMaster::where('fc_mappingcode', $decode_fc_mappingcode)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->first();

        session(['fc_mappingcode_global' => $decode_fc_mappingcode]);
        $data['data'] = MappingMaster::with('branch', 'transaksi', 'tipe')->where('fc_mappingcode', $decode_fc_mappingcode)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['trxaccmethod'] = TransaksiType::where('fc_trx', 'TRXACCMETHOD')->get();
        $data['fc_credit_previledge'] = json_decode($mappingMaster->fc_credit_previledge);
        $data['fc_debit_previledge'] = json_decode($mappingMaster->fc_debit_previledge);
        return view('apps.master-mapping.detail', $data);
        // dd($data);
    }

    public function datatables()
    {
        $data = MappingMaster::with('transaksi', 'tipe')->where('fc_status', 'F')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sum_debit', function ($row) {
                $sum_debit = MappingDetail::where('fc_mappingpos', "D")
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->where('fc_mappingcode', $row->fc_mappingcode)
                    ->count();

                return $sum_debit;
            })
            ->addColumn('sum_credit', function ($row) {
                $sum_credit = MappingDetail::where('fc_mappingpos', "C")
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->where('fc_mappingcode', $row->fc_mappingcode)
                    ->count();

                return $sum_credit;
            })
            ->make(true);
        // dd($data);
    }

    public function get_transaksi($action)
    {
        $fc_action = base64_decode($action);

        $data = TransaksiType::where([
            'fc_action' => $fc_action,
        ])
            ->get();

        if (empty($data)) {
            return [
                'status' => 200,
            ];
        }

        return ApiFormatter::getResponse($data);
    }

    public function store_update(Request $request)
    {
        // validator
        $validator = Validator::make($request->all(), [
            'fc_mappingcode' => 'required|unique:t_mappingmst,fc_mappingcode',
            'fc_mappingname' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $mapping_mst = MappingMaster::where('fc_mappingcode', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->first();

        if (empty($mapping_mst)) {
            // create TempInvoiceMst
            $insert = MappingMaster::create([
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_mappingcode' => $request->fc_mappingcode,
                'fc_mappingname' => $request->fc_mappingname,
                'fc_mappingcashtype' => $request->fc_mappingcashtype,
                'fc_mappingtrxtype' => $request->fc_mappingtrxtype,
                'fc_status' => 'I',
                'fc_hold' => $request->fc_hold,
                'fc_balancerelation' => $request->fc_balancerelation,
                'created_by' => auth()->user()->fc_userid,
            ]);

            if ($insert) {
                return [
                    'status' => 201,
                    'message' => 'Data berhasil disimpan',
                    'link' => '/apps/master-mapping/create/' . base64_encode($request->fc_mappingcode)
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

    public function hold($fc_mappingcode)
    {
        $data = MappingMaster::where('fc_mappingcode', $fc_mappingcode)->update([
            'fc_hold' => 'T',
        ]);

        if ($data) {
            return [
                'status' => 200,
                'message' => 'Data berhasil di Hold'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Data gagal di Hold'
            ];
        }
    }

    public function unhold($fc_mappingcode)
    {
        $data = MappingMaster::where('fc_mappingcode', $fc_mappingcode)->update([
            'fc_hold' => 'F',
        ]);

        if ($data) {
            return [
                'status' => 200,
                'message' => 'Buka Hold berhasil'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Buka Hold gagal'
            ];
        }
    }

    public function cancel($fc_mappingcode)
    {
        $encoded_fc_mappingcode = base64_decode($fc_mappingcode);
        DB::beginTransaction();

        try {
            MappingDetail::where('fc_mappingcode', $encoded_fc_mappingcode)->delete();
            MappingMaster::where('fc_mappingcode', $encoded_fc_mappingcode)->delete();


            DB::commit();

            return [
                'status' => 201, // SUCCESS
                'link' => '/apps/master-mapping',
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

    public function submit($fc_mappingcode)
    {
        DB::beginTransaction();

        try {
            MappingMaster::where([
                'fc_mappingcode' =>  $fc_mappingcode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
            ])
                ->update([
                    'fc_status' => "F",
                    'updated_at' => Carbon::now(),
                ]);

            DB::commit();

            return [
                'status' => 201, // SUCCESS
                'link' => '/apps/master-mapping',
                'message' => 'Data berhasil disubmit'
            ];
        } catch (\Exception $e) {

            DB::rollback();

            return [
                'status'     => 300, // GAGAL
                'message'       => (env('APP_DEBUG', 'true') == 'true') ? $e->getMessage() : 'Operation error'
            ];
        }
    }

    public function update_trxaccmethod_debit($fc_mappingcode, Request $request){
        // validator
        $validator = Validator::make($request->all(), [
            'trxaccmethod' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $decode_fc_mappingcode = base64_decode($fc_mappingcode);
        $json_encode = json_encode($request->trxaccmethod);
        $cek_kredit = MappingMaster::where('fc_mappingcode', $decode_fc_mappingcode)
                            ->where('fc_branch', auth()->user()->fc_branch)
                            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                            ->first();
         
        // value 'empty' hanya sementara apabila kondisi tidak terpenuhi
        $onceValue = 'empty';
        $lbpbValue = 'empty';
        $linvValue = 'empty';

        foreach (json_decode($json_encode) as $value) {
            if ($value === 'ONCE') {
                $onceValue = $value;
            } 

            if ($value === 'LBPB') {
                $lbpbValue = $value;
            } 
            
            if ($value === 'LINV') {
                $linvValue = $value;
            }
        }                    

        // cek fc_credit_previledge apakah terdapat value 'ONCE', 'LBPB', 'LINV' di dalam array of string
        $cek_once_kredit = in_array($onceValue,json_decode($cek_kredit->fc_credit_previledge));
        $cek_lbpb_kredit = in_array($lbpbValue,json_decode($cek_kredit->fc_credit_previledge));
        $cek_linv_kredit = in_array($linvValue,json_decode($cek_kredit->fc_credit_previledge));

        if($cek_once_kredit){
            return [
                'status' => 300,
                'message' => 'Nonaktifkan One To Many pada Kredit terlebih dahulu'
            ];
        }

        if($cek_lbpb_kredit){
            return [
                'status' => 300,
                'message' => 'Nonaktifkan Look BPB pada Kredit terlebih dahulu'
            ];
        }

        if($cek_linv_kredit){
            return [
                'status' => 300,
                'message' => 'Nonaktifkan Look Invoice pada Kredit terlebih dahulu'
            ];
        }
        
        $cek_mapping_detail = MappingDetail::where('fc_mappingcode', $decode_fc_mappingcode)
                                            ->where('fc_mappingpos', 'D')
                                            ->where('fc_branch', auth()->user()->fc_branch)
                                            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                            ->count();

        // apabila dia update dan memilih One To Many tetapi di mapping detail sudah ada lebih dari 1
        if($cek_mapping_detail > 1 && $onceValue === 'ONCE'){
            return [
                'status' => 300,
                'message' => 'Jika memilih One To Many hanya boleh ada 1 Mapping Debit'
            ];
        }
        
        // insert ke t_mappingmst
        $data_update = MappingMaster::where('fc_mappingcode', $decode_fc_mappingcode)
                                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                    ->where('fc_branch', auth()->user()->fc_branch)
                                    ->update([
                                        'fc_debit_previledge' => $json_encode,
                                        'updated_by' => auth()->user()->fc_userid
                                    ]);
        if($data_update){
            return [
                'status' => 201,
                'link' => '/apps/master-mapping/detail/' . base64_encode($decode_fc_mappingcode),
                'message' => 'Metode Transaksi berhasil diupdate',
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Metode Transaksi gagal diupdate',
            ];
        }
        
    }

    public function update_trxaccmethod_kredit($fc_mappingcode, Request $request){
        // validator
        $validator = Validator::make($request->all(), [
            'trxaccmethod' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $decode_fc_mappingcode = base64_decode($fc_mappingcode);

        $json_encode = json_encode($request->trxaccmethod);

        $cek_debit = MappingMaster::where('fc_mappingcode', $decode_fc_mappingcode)
                            ->where('fc_branch', auth()->user()->fc_branch)
                            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                            ->first();
         
        // value 'empty' hanya sementara apabila kondisi tidak terpenuhi
        $onceValue = 'empty';
        $lbpbValue = 'empty';
        $linvValue = 'empty';

        foreach (json_decode($json_encode) as $value) {
            if ($value === 'ONCE') {
                $onceValue = $value;
            } 

            if ($value === 'LBPB') {
                $lbpbValue = $value;
            } 
            
            if ($value === 'LINV') {
                $linvValue = $value;
            }
        }                    

        // cek fc_debit_previledge apakah terdapat value 'ONCE', 'LBPB', 'LINV' di dalam array of string
        $cek_once_debit = in_array($onceValue,json_decode($cek_debit->fc_debit_previledge));
        $cek_lbpb_debit = in_array($lbpbValue,json_decode($cek_debit->fc_debit_previledge));
        $cek_linv_debit = in_array($linvValue,json_decode($cek_debit->fc_debit_previledge));

        if($cek_once_debit){
            return [
                'status' => 300,
                'message' => 'Nonaktifkan One To Many pada Debit terlebih dahulu'
            ];
        }

        if($cek_lbpb_debit){
            return [
                'status' => 300,
                'message' => 'Nonaktifkan Look BPB pada Debit terlebih dahulu'
            ];
        }

        if($cek_linv_debit){
            return [
                'status' => 300,
                'message' => 'Nonaktifkan Look Invoice pada Debit terlebih dahulu'
            ];
        }

        $cek_mapping_detail = MappingDetail::where('fc_mappingcode', $decode_fc_mappingcode)
                                            ->where('fc_mappingpos', 'C')
                                            ->where('fc_branch', auth()->user()->fc_branch)
                                            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                            ->count();

        // apabila dia update dan memilih One To Many tetapi di mapping detail sudah ada lebih dari 1
        if($cek_mapping_detail > 1 && $onceValue === 'ONCE'){
            return [
                'status' => 300,
                'message' => 'Jika memilih One To Many hanya boleh ada 1 Mapping Kredit'
            ];
        }

        // insert ke t_mappingmst
        $data_update = MappingMaster::where('fc_mappingcode', $decode_fc_mappingcode)
                                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                    ->where('fc_branch', auth()->user()->fc_branch)
                                    ->update([
                                        'fc_credit_previledge' => $json_encode,
                                        'updated_by' => auth()->user()->fc_userid
                                    ]);
        if($data_update){
            return [
                'status' => 201,
                'link' => '/apps/master-mapping/detail/' . base64_encode($decode_fc_mappingcode),
                'message' => 'Metode Transaksi berhasil diupdate',
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Metode Transaksi gagal diupdate',
            ];
        }
    }
}
