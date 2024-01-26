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

class MasterMappingCreateController extends Controller
{
    public function create($fc_mappingcode)
    {
        $encoded_fc_mappingcode = base64_decode($fc_mappingcode);
        $mappingMaster = MappingMaster::where('fc_mappingcode', $encoded_fc_mappingcode)
                                        ->where('fc_branch', auth()->user()->fc_branch)
                                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                        ->first();

        $data['data'] = MappingMaster::with('transaksi', 'tipe', 'branch')
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->where('fc_mappingcode', $encoded_fc_mappingcode)->first();

        $data['trxaccmethod'] = TransaksiType::where('fc_trx','TRXACCMETHOD')->get();
        $data['fc_credit_previledge'] = json_decode($mappingMaster->fc_credit_previledge);
        $data['fc_debit_previledge'] = json_decode($mappingMaster->fc_debit_previledge);
        return view('apps.master-mapping.create', $data);
        // dd($data);
    }

    public function datatables_debit($fc_mappingcode)
    {
        $encoded_fc_mappingcode = base64_decode($fc_mappingcode);
        $data = MappingDetail::with('mst_coa')->where('fc_mappingcode', $encoded_fc_mappingcode)
                                ->where('fc_mappingpos', "D")
                                ->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function datatables_kredit($fc_mappingcode)
    {
        $encoded_fc_mappingcode = base64_decode($fc_mappingcode);
        $data = MappingDetail::with('mst_coa')->where('fc_mappingcode', $encoded_fc_mappingcode)
                                ->where('fc_mappingpos', "C")
                                ->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }


    public function insert_debit(Request $request){
        $validator = Validator::make($request->all(), [
            'fc_mappingcode' => 'required',
            'fc_coacode' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        // cek di master mapping fc_balancerelation sama dengan '1 to N'
        $cek_master_mapping = MappingMaster::where('fc_mappingcode', $request->fc_mappingcode)
                            ->where('fc_branch', auth()->user()->fc_branch)
                            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)->first();

        // cek di master mapping fc_balancerelation sama dengan '1 to N'
        if($cek_master_mapping && $cek_master_mapping->fc_balancerelation === '1 to N'){
            // filter berdasarkan mappingcode
            $cek_mapping_detail = MappingDetail::where('fc_mappingcode', $request->fc_mappingcode)
                                ->where('fc_branch', auth()->user()->fc_branch)
                                ->where('fc_divisioncode', auth()->user()->fc_divisioncode)->get();

             // klasifikasikan berdasarkan fc_mappingpos
            $filter_debit = $cek_mapping_detail->where('fc_mappingpos', 'D');
            $filter_kredit = $cek_mapping_detail->where('fc_mappingpos', 'C');

            // Hitung jumlah Debit (mapping pos D)
            $count_debit = $filter_debit->count();
            // Hitung jumlah Kredit (mapping pos C)
            $count_kredit = $filter_kredit->count();

             // Cek apakah sudah ada catatan Debit (mapping pos D) lebih dari satu
            // Jika iya, pastikan hanya satu catatan Kredit (mapping pos C) yang diizinkan
            if ($count_debit > 0) {
                if ($count_kredit > 1) {
                    return [
                        'status' => 300,
                        'message' => 'Hanya boleh ada satu catatan Debit atau Kredit karena relasi One to Many'
                    ];
                }
            }
        }

        if($cek_master_mapping && is_array(json_decode($cek_master_mapping->fc_debit_previledge)) && count(json_decode($cek_master_mapping->fc_debit_previledge)) == 1 && json_decode($cek_master_mapping->fc_debit_previledge)[0] === ""){
            return [
                'status' => 300,
                'message' => 'Pilih hak istimewa untuk Debit terlebih dahulu'
            ];
        }
        
        if($cek_master_mapping && in_array('ONCE', json_decode($cek_master_mapping->fc_debit_previledge))){
            $count_debit = MappingDetail::where('fc_mappingcode', $request->fc_mappingcode)
                                ->where('fc_branch', auth()->user()->fc_branch)
                                ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                ->where('fc_mappingpos', 'D')->count();
            if($count_debit > 0){
                return [
                    'status' => 300,
                    'message' => 'Hanya boleh ada satu catatan Debit'
                ];
            }
        }

        $exist_coa = MappingDetail::where('fc_mappingcode', $request->fc_mappingcode)
        ->where('fc_coacode',$request->fc_coacode)
       ->where('fc_mappingpos', "C")
       ->where('fc_branch', auth()->user()->fc_branch)->count();

        $count_coa = MappingDetail::where('fc_mappingcode', $request->fc_mappingcode)
        ->where('fc_coacode', $request->fc_coacode)
        ->where('fc_mappingpos', "D")
        ->where('fc_branch', auth()->user()->fc_branch)->count();

        if($exist_coa > 0){
            return [
                'status' => 300,
                'message' => 'Kode COA sudah ada di Kredit'
            ];
        }

        if($count_coa > 0){
                return [
                    'status' => 300,
                    'message' => 'Kode COA sudah ada'
                ];
        }else{
            $data = MappingDetail::create([
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_mappingcode' => $request->fc_mappingcode,
                'fc_coacode' => $request->fc_coacode,
                'fc_mappingpos' => "D",
                'created_by' => auth()->user()->fc_userid
            ]);
    
            if($data){
                return [
                    'status' => 200,
                    'message' => 'Debit berhasil diinsert',
                ];
            }else{
                return [
                    'status' => 300,
                    'message' => 'Debit gagal diinsert',
                ];
            } 
        } 
    }

    public function insert_kredit(Request $request){
        $validator = Validator::make($request->all(), [
            'fc_mappingcode' => 'required',
            'fc_coacode' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

         // cek di master mapping fc_balancerelation sama dengan '1 to N'
         $cek_master_mapping = MappingMaster::where('fc_mappingcode', $request->fc_mappingcode)
         ->where('fc_branch', auth()->user()->fc_branch)
         ->where('fc_divisioncode', auth()->user()->fc_divisioncode)->first();

        if($cek_master_mapping && $cek_master_mapping->fc_balancerelation === '1 to N'){
            // filter berdasarkan mappingcode
            $cek_mapping_detail = MappingDetail::where('fc_mappingcode', $request->fc_mappingcode)
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)->get();

            // klasifikasikan berdasarkan fc_mappingpos
            $filter_debit = $cek_mapping_detail->where('fc_mappingpos', 'D');
            $filter_kredit = $cek_mapping_detail->where('fc_mappingpos', 'C');

            // Hitung jumlah Debit (mapping pos D)
            $count_debit = $filter_debit->count();
            // Hitung jumlah Kredit (mapping pos C)
            $count_kredit = $filter_kredit->count();

             // hanya salah satu antara Debit atau Kredit yang boleh punya banyak record, lainnya hanya satu
             if ($count_kredit > 0) {
                if ($count_debit > 1) {
                    return [
                        'status' => 300,
                        'message' => 'Hanya boleh ada satu catatan Debit atau Kredit karena relasi One to Many'
                    ];
                }
            }
        }

        if($cek_master_mapping && is_array(json_decode($cek_master_mapping->fc_credit_previledge)) && count(json_decode($cek_master_mapping->fc_credit_previledge)) == 1 && json_decode($cek_master_mapping->fc_credit_previledge)[0] === ""){
            return [
                'status' => 300,
                'message' => 'Pilih hak istimewa untuk Kredit terlebih dahulu'
            ];
        }
        
        if($cek_master_mapping && in_array('ONCE', json_decode($cek_master_mapping->fc_credit_previledge))){
            $count_credit = MappingDetail::where('fc_mappingcode', $request->fc_mappingcode)
                                ->where('fc_branch', auth()->user()->fc_branch)
                                ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                ->where('fc_mappingpos', 'C')->count();
            if($count_credit > 0){
                return [
                    'status' => 300,
                    'message' => 'Hanya boleh ada satu catatan Credit'
                ];
            }
        }

        $exist_coa = MappingDetail::where('fc_mappingcode', $request->fc_mappingcode)
         ->where('fc_coacode',$request->fc_coacode)
        ->where('fc_mappingpos', "D")
        ->where('fc_branch', auth()->user()->fc_branch)->count();

        $count_coa = MappingDetail::where('fc_mappingcode', $request->fc_mappingcode)
        ->where('fc_coacode', $request->fc_coacode)
        ->where('fc_mappingpos', "C")
        ->where('fc_branch', auth()->user()->fc_branch)->count();

        if($exist_coa > 0){
            return [
                'status' => 300,
                'message' => 'Kode COA sudah ada di Debit'
            ];
        }

        if($count_coa > 0){
                return [
                    'status' => 300,
                    'message' => 'Kode COA sudah ada'
                ];
        }else{
            $data = MappingDetail::create([
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_mappingcode' => $request->fc_mappingcode,
                'fc_coacode' => $request->fc_coacode,
                'fc_mappingpos' => "C",
                'created_by' => auth()->user()->fc_userid
            ]);
    
            if($data){
                return [
                    'status' => 200,
                    'message' => 'Kredit berhasil diinsert',
                ];
            }else{
                return [
                    'status' => 300,
                    'message' => 'Kredit gagal diinsert',
                ];
            } 
        }

       
    }

    public function delete_debit($fc_coacode){

        // decode fc_mappingcode
        $decode_fc_coacode = base64_decode($fc_coacode);

       // jika fc_mappingcode samadengan null
         if($fc_coacode == null){
            return [
                'status' => 300,
                'message' => 'Mapping Code tidak boleh kosong',
            ];
        }
        $data = MappingDetail::where('fc_coacode', $decode_fc_coacode)
                                ->where('fc_mappingpos','D')->delete();

        if($data){
            return [
                'status' => 200,
                'message' => 'Debit berhasil dihapus',
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Debit gagal dihapus',
            ];
        } 
    }

    public function delete_kredit($fc_coacode){

        // decode fc_mappingcode
        $decode_fc_coacode = base64_decode($fc_coacode);

       // jika fc_mappingcode samadengan null
         if($fc_coacode == null){
            return [
                'status' => 300,
                'message' => 'Mapping Code tidak boleh kosong',
            ];
        }
        $data = MappingDetail::where('fc_coacode', $decode_fc_coacode)
                                ->where('fc_mappingpos','C')->delete();

        if($data){
            return [
                'status' => 200,
                'message' => 'Debit berhasil dihapus',
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Debit gagal dihapus',
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
                'link' => '/apps/master-mapping',
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
                'link' => '/apps/master-mapping',
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
