<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Helpers\Convert;
use App\Models\MappingMaster;
use App\Models\MappingDetail;
use Carbon\Carbon;
use DB;
use App\Models\NotificationDetail;
use App\Models\TempTrxAccountingMaster;
use App\Models\TempTrxAccountingDetail;
use App\Models\TrxAccountingMaster;
use App\Models\TrxAccountingDetail;
use Validator;
use Auth;
use App\Helpers\ApiFormatter;
use App\Models\Approvement;
use App\Models\InvMaster;
use App\Models\InvoiceMst;
use App\Models\InvTrx;
use App\Models\MappingUser;
use App\Models\MasterCoa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Round;
use Yajra\DataTables\DataTables;

class TransaksiDetailController extends Controller
{
    public function datatables(){
        $data = TempTrxAccountingDetail::with('coamst', 'payment')->where('fc_branch', auth()->user()->fc_branch)->where('fc_trxno', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_debit(){
        $data = TempTrxAccountingDetail::with('coamst', 'payment')->where('fc_statuspos', 'D')->where('fc_branch', auth()->user()->fc_branch)->where('fc_trxno', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_kredit(){
        $data = TempTrxAccountingDetail::with('coamst', 'payment')->where('fc_statuspos', 'C')->where('fc_branch', auth()->user()->fc_branch)->where('fc_trxno', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_invoice($fc_docreference)
    {
        $decode_docreference = base64_decode($fc_docreference);
        $data = InvoiceMst::with('domst', 'pomst', 'somst', 'romst', 'supplier', 'customer')->where('fc_branch', auth()->user()->fc_branch)->where('fc_entitycode', $decode_docreference)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_bpb($fc_docreference)
    {
        $decode_docreference = base64_decode($fc_docreference);
        $data = InvoiceMst::with('domst', 'pomst', 'somst', 'romst', 'supplier', 'customer')->where('fc_branch', auth()->user()->fc_branch)->where('fc_entitycode', $decode_docreference)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function get_data_coa($coacode)
    {
        $fc_coacode = base64_decode($coacode);

        $data = MappingDetail::with('mst_coa.transaksitype')->where([
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_coacode' => $fc_coacode,
        ])
            ->get();

        if (empty($data)) {
            return [
                'status' => 200,
            ];
        }

        return ApiFormatter::getResponse($data);
    }

    public function get_data_coa_kredit($coacode)
    {
        $fc_coacode = base64_decode($coacode);

        $data = MappingDetail::with('mst_coa.transaksitype')->where([
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_coacode' => $fc_coacode,
        ])
            ->get();

        if (empty($data)) {
            return [
                'status' => 200,
            ];
        }

        return ApiFormatter::getResponse($data);
    }

    public function get_coa($mappingMst){
        $fc_mappingcode = base64_decode($mappingMst); 

        $data = MappingDetail::with('mst_coa')
        ->where([
            'fc_mappingcode' => $fc_mappingcode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_mappingpos' => 'D',
        ])->get();

        if (empty($data)) {
            return [
                'status' => 200,
            ];
        }

        return ApiFormatter::getResponse($data);
    }

    public function get_coa_kredit($mappingMst){
        $fc_mappingcode = base64_decode($mappingMst); 

        $data = MappingDetail::with('mst_coa')
        ->where([
            'fc_mappingcode' => $fc_mappingcode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_mappingpos' => 'C',
        ])->get();

        if (empty($data)) {
            return [
                'status' => 200,
            ];
        }

        return ApiFormatter::getResponse($data);
    }

    public function delete($fc_coacode, $fn_rownum, $fc_balancerelation, $fc_mappingcode)
    {
        // decode
        $fc_balancerelation_decode = base64_decode($fc_balancerelation);
        $fc_mappingcode_decode = base64_decode($fc_mappingcode);
        DB::beginTransaction();

        try {
            $deletedRow = TempTrxAccountingDetail::where('fc_coacode', $fc_coacode)
            ->where('fn_rownum', $fn_rownum)
            ->first();
    
            // cek status_pos row yang dihapus
            $status_pos = $deletedRow->fc_statuspos;
            
            // mengambil previledge sesuai dari mapping master
            $previledge = MappingMaster::where('fc_mappingcode', $fc_mappingcode_decode)
                ->where('fc_branch', auth()->user()->fc_branch)
                ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                ->first();
        
            // cek apakah status_pos 'D' atau 'C'
            if ($status_pos === 'D' || $status_pos === 'C') {
                $debitPreviledge = json_decode($previledge->fc_debit_previledge);
                $creditPreviledge = json_decode($previledge->fc_credit_previledge);
                
                // kondisi untuk cek apakah terdapat value ONCE di kredit apabila yang dihapus debit dan sebaliknya
                if (in_array('ONCE', ($status_pos === 'D' ? $creditPreviledge : $debitPreviledge))) {
                    if (!$deletedRow) {
                        return [
                            'status' => 300,
                            'message' => 'Data tidak ditemukan'
                        ];
                    }
        
                    $isCredit = $deletedRow->fc_statuspos === 'C';
                    $statusLawan = $isCredit ? 'D' : 'C'; // Status yang berlawanan dengan yang dihapus
        
                    // Hitung jumlah nominal selain row yang dihapus
                    $remainingNominal = TempTrxAccountingDetail::where('fn_rownum', '!=', $fn_rownum)
                        ->where('fc_statuspos', $status_pos)
                        ->where('fc_trxno', auth()->user()->fc_userid)
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                        ->sum('fm_nominal');
        
                    $countItem = TempTrxAccountingDetail::where('fc_statuspos', $status_pos)
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)->count();
        
                    $delete = TempTrxAccountingDetail::where('fc_coacode', $fc_coacode)
                        ->where('fn_rownum', $fn_rownum)
                        ->delete();
        
                    if ($delete) {
                        // Update nominal di debit jika yang dihapus adalah kredit, atau sebaliknya
                        if ($isCredit) {
                            if ($countItem < 2) {
                                TempTrxAccountingDetail::where('fc_statuspos', $statusLawan)
                                    ->where('fc_trxno', auth()->user()->fc_userid)
                                    ->where('fc_branch', auth()->user()->fc_branch)
                                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                    ->update([
                                        'fm_nominal' => '0',
                                    ]);
                            } else {
                                TempTrxAccountingDetail::where('fc_statuspos', $statusLawan)
                                    ->where('fc_trxno', auth()->user()->fc_userid)
                                    ->where('fc_branch', auth()->user()->fc_branch)
                                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                    ->update([
                                        'fm_nominal' => $remainingNominal,
                                    ]);
                            }
                        }else{
                            if ($countItem < 2) {
                                TempTrxAccountingDetail::where('fc_statuspos', $statusLawan)
                                    ->where('fc_trxno', auth()->user()->fc_userid)
                                    ->where('fc_branch', auth()->user()->fc_branch)
                                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                    ->update([
                                        'fm_nominal' => '0',
                                    ]);
                            } else {
                                TempTrxAccountingDetail::where('fc_statuspos', $statusLawan)
                                    ->where('fc_trxno', auth()->user()->fc_userid)
                                    ->where('fc_branch', auth()->user()->fc_branch)
                                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                    ->update([
                                        'fm_nominal' => $remainingNominal,
                                    ]);
                            }
                        }
        
                        DB::commit();
                        return response()->json([
                            'status' => 200,
                            'message' => 'Data berhasil dihapus'
                        ]);
                    }
        
                    DB::rollback();
                    return [
                        'status' => 300,
                        'message' => 'Error'
                    ];
                } else {
                    $delete = TempTrxAccountingDetail::where('fc_coacode', $fc_coacode)
                        ->where('fn_rownum', $fn_rownum)
                        ->delete();
        
                    if ($delete) {
                        DB::commit();
                        return response()->json([
                            'status' => 200,
                            'message' => 'Data berhasil dihapus'
                        ]);
                    } else {
                        DB::rollback();
                        return [
                            'status' => 300,
                            'message' => 'Terjadi Error Saat Delete Data'
                        ];
                    }
                }
            } else {
                $delete = TempTrxAccountingDetail::where('fc_coacode', $fc_coacode)
                    ->where('fn_rownum', $fn_rownum)
                    ->delete();
        
                if ($delete) {
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } else {
                    DB::rollback();
                    return [
                        'status' => 300,
                        'message' => 'Terjadi Error Saat Delete Data'
                    ];
                }
            }
            
        } catch (\Exception $e) {
            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    
    public function update_pembayaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fc_paymentmethod_edit' => 'required',
            'fn_rownum' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $update_pembayaran = TempTrxAccountingDetail::where([
            'fc_trxno' => auth()->user()->fc_userid,
            'fn_rownum' => $request->fn_rownum,
        ])->update([
            'fc_paymentmethod' => $request->fc_paymentmethod_edit,
            'fc_refno' => $request->fc_refno_edit,
            'fd_agingref' => $request->fd_agingref_edit,
            'fv_description' => $request->fv_description_payment
        ]);

        if ($update_pembayaran) {
            return [
                'status' => 200,
                'message' => 'Data berhasil diupdate'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Error'
        ];
        // dd($request);
    }

    public function update_edit_pembayaran(Request $request, $fc_trxno)
    {
        $decode_fc_trxno = base64_decode($fc_trxno);
        
        $validator = Validator::make($request->all(), [
            'fc_paymentmethod_edit' => 'required',
            'fn_rownum' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $update_pembayaran = TrxAccountingDetail::where([
            'fc_trxno' => $decode_fc_trxno,
            'fn_rownum' => $request->fn_rownum,
        ])->update([
            'fc_paymentmethod' => $request->fc_paymentmethod_edit,
            'fc_refno' => $request->fc_refno_edit,
            'fd_agingref' => $request->fd_agingref_edit,
            'fv_description' => $request->fv_description_payment
        ]);

        if ($update_pembayaran) {
            return [
                'status' => 200,
                'message' => 'Data berhasil diupdate'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Error'
        ];
        // dd($request);
    }

    public function edit_delete($fc_trxno, $fc_coacode, $fn_rownum,$fc_balancerelation, $fc_mappingcode)
    {
        // decode
        $fc_balancerelation_decode = base64_decode($fc_balancerelation);
        $fc_mappingcode_decode = base64_decode($fc_mappingcode);
        $decode_fc_trxno = base64_decode($fc_trxno);
        DB::beginTransaction();

        try {
            $deletedRow = TrxAccountingDetail::where('fc_coacode', $fc_coacode)
            ->where('fn_rownum', $fn_rownum)
            ->first();
    
            // cek status_pos row yang dihapus
            $status_pos = $deletedRow->fc_statuspos;
            
            // mengambil previledge sesuai dari mapping master
            $previledge = MappingMaster::where('fc_mappingcode', $fc_mappingcode_decode)
                ->where('fc_branch', auth()->user()->fc_branch)
                ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                ->first();
        
            // cek apakah status_pos 'D' atau 'C'
            if ($status_pos === 'D' || $status_pos === 'C') {
                $debitPreviledge = json_decode($previledge->fc_debit_previledge);
                $creditPreviledge = json_decode($previledge->fc_credit_previledge);
                
                // kondisi untuk cek apakah terdapat value ONCE di kredit apabila yang dihapus debit dan sebaliknya
                if (in_array('ONCE', ($status_pos === 'D' ? $creditPreviledge : $debitPreviledge))) {
                    if (!$deletedRow) {
                        return [
                            'status' => 300,
                            'message' => 'Data tidak ditemukan'
                        ];
                    }
        
                    $isCredit = $deletedRow->fc_statuspos === 'C';
                    $statusLawan = $isCredit ? 'D' : 'C'; // Status yang berlawanan dengan yang dihapus
        
                    // Hitung jumlah nominal selain row yang dihapus
                    $remainingNominal = TrxAccountingDetail::where('fn_rownum', '!=', $fn_rownum)
                        ->where('fc_statuspos', $status_pos)
                        ->where('fc_trxno', $decode_fc_trxno)
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                        ->sum('fm_nominal');
        
                    $countItem = TrxAccountingDetail::where('fc_statuspos', $status_pos)
                        ->where('fc_trxno', $decode_fc_trxno)
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)->count();
        
                    $delete = TrxAccountingDetail::where('fc_coacode', $fc_coacode)
                        ->where('fc_trxno', $decode_fc_trxno)
                        ->where('fn_rownum', $fn_rownum)
                        ->delete();
        
                    if ($delete) {
                        // Update nominal di debit jika yang dihapus adalah kredit, atau sebaliknya
                        if ($isCredit) {
                            if ($countItem < 2) {
                                TrxAccountingDetail::where('fc_statuspos', $statusLawan)
                                    ->where('fc_trxno', $decode_fc_trxno)
                                    ->where('fc_branch', auth()->user()->fc_branch)
                                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                    ->update([
                                        'fm_nominal' => '0',
                                    ]);
                            } else {
                                TrxAccountingDetail::where('fc_statuspos', $statusLawan)
                                    ->where('fc_trxno', $decode_fc_trxno)
                                    ->where('fc_branch', auth()->user()->fc_branch)
                                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                    ->update([
                                        'fm_nominal' => $remainingNominal,
                                    ]);
                            }
                            // dd($countItem);
                        }else{
                            if ($countItem < 2) {
                                TrxAccountingDetail::where('fc_statuspos', $statusLawan)
                                    ->where('fc_trxno', $decode_fc_trxno)
                                    ->where('fc_branch', auth()->user()->fc_branch)
                                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                    ->update([
                                        'fm_nominal' => '0',
                                    ]);
                            } else {
                                TrxAccountingDetail::where('fc_statuspos', $statusLawan)
                                    ->where('fc_trxno', $decode_fc_trxno)
                                    ->where('fc_branch', auth()->user()->fc_branch)
                                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                    ->update([
                                        'fm_nominal' => $remainingNominal,
                                    ]);
                            }
                        }
        
                        DB::commit();
                        return response()->json([
                            'status' => 200,
                            'message' => 'Data berhasil dihapus'
                        ]);
                    }
        
                    DB::rollback();
                    return [
                        'status' => 300,
                        'message' => 'Error'
                    ];
                    // dd($decode_fc_trxno);
                } else {
                    $delete = TrxAccountingDetail::where('fc_coacode', $fc_coacode)
                        ->where('fn_rownum', $fn_rownum)
                        ->delete();
        
                    if ($delete) {
                        DB::commit();
                        return response()->json([
                            'status' => 200,
                            'message' => 'Data berhasil dihapus'
                        ]);
                    } else {
                        DB::rollback();
                        return [
                            'status' => 300,
                            'message' => 'Terjadi Error Saat Delete Data'
                        ];
                    }
                }
            } else {
                $delete = TrxAccountingDetail::where('fc_coacode', $fc_coacode)
                    ->where('fn_rownum', $fn_rownum)
                    ->delete();
        
                if ($delete) {
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } else {
                    DB::rollback();
                    return [
                        'status' => 300,
                        'message' => 'Terjadi Error Saat Delete Data'
                    ];
                }
            }
            
        } catch (\Exception $e) {
            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function store_debit(Request $request){
        DB::beginTransaction();
    
        try {
            $validator = Validator::make($request->all(), [
                'fc_coacode' => 'required',
                'fc_paymentmethod' => 'required',
            ]);
    
            if($validator->fails()) {
                return [
                    'status' => 300,
                    'message' => $validator->errors()->first()
                ];
            }
    
            $temp_detail = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)->orderBy('fn_rownum', 'DESC')->first();
            $fn_rownum = 1;
            if (!empty($temp_detail)) {
                $fn_rownum = $temp_detail->fn_rownum + 1;
            }
    
           
            $insert_debit = TempTrxAccountingDetail::create([
                'fc_branch' => auth()->user()->fc_branch,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_trxno' => auth()->user()->fc_userid,
                'fn_rownum' => $fn_rownum,
                'fc_coacode' => $request->fc_coacode,
                'fc_statuspos' => 'D',
                'fc_paymentmethod' => $request->fc_paymentmethod,
                'fc_refno' => ($request->fc_refno === '') ? NULL : $request->fc_refno,
                'fd_agingref' => ($request->fd_agingref === '') ? NULL : $request->fd_agingref,
                'created_by' => auth()->user()->fc_userid
            ]);
    
            if($insert_debit){
                DB::commit(); 
                return [
                    'status' => 200,
                    'message' => 'Data berhasil disimpan'
                ];
            }else{
                DB::rollback(); 
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];
            }
        } catch (\Exception $e) {
            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    // Transaksi Utama
    public function store_bpb(Request $request){
        DB::beginTransaction();
    
        try {
            $fc_docreference = base64_decode($request->fc_docreference);
            $fc_mappingcode_decode = base64_decode($request->fc_mappingcode);
            $validator = Validator::make($request->all(), [
                'fc_invno' => 'required',
                'nominal' => 'required',
                'fc_docreference' => 'required'
            ]);
    
            if($validator->fails()) {
                return [
                    'status' => 300,
                    'message' => $validator->errors()->first()
                ];
            }

            $invtrx = $this->validateAndUpdateInvoiceBpb($request);
    
            if (is_array($invtrx)) {
                return $invtrx;
            } 

            $cek_exist = TempTrxAccountingDetail::where('fv_description', $request->fc_invno)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->count();

            if($cek_exist > 0){
                return [
                    'status' => 300,
                    'message' => 'No.Invoice sudah tersedia'
                ];
            }
    
            $temp_detail = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)->orderBy('fn_rownum', 'DESC')->first();
            $fn_rownum = 1;
            if (!empty($temp_detail)) {
                $fn_rownum = $temp_detail->fn_rownum + 1;
            }
            
            $fc_paymentmethod = 'NON';
            $fc_directpayment = DB::table('t_coa')
                                ->where('fc_coacode', '310.311')
                                ->value('fc_directpayment');
            if($fc_directpayment == 'F'){
                $fc_paymentmethod = 'NON';
            }else{
                $fc_paymentmethod = 'TRANS';
            }


            $insert = TempTrxAccountingDetail::create([
                'fc_branch' => auth()->user()->fc_branch,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_trxno' => auth()->user()->fc_userid,
                'fn_rownum' => $fn_rownum,
                'fc_coacode' => '310.311.' . $fc_docreference,
                'fc_statuspos' => $request->reference_bpb,
                'fm_nominal' => $request->nominal,
                'fc_paymentmethod' => $fc_paymentmethod,
                'fv_description' => $request->fc_invno,
                'created_by' => auth()->user()->fc_userid
            ]);
    
            if($insert){
                if ($request->reference_bpb == 'C') {
                    $mappingRecord = MappingMaster::where('fc_mappingcode', $fc_mappingcode_decode)
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                        ->whereJsonContains('fc_debit_previledge', 'ONCE')
                        ->first();
    
                        if ($mappingRecord) {
                            $totalNominal = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                                            ->where('fc_statuspos', 'C')
                                            ->where('fc_branch', auth()->user()->fc_branch)
                                            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                            ->sum('fm_nominal');
                            // $totalNominal += $request->nominal;
                            TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                                                    ->where('fc_statuspos', 'D')
                                                    ->update(['fm_nominal' => $totalNominal]);
                        }
                }else{
                    $mappingRecord = MappingMaster::where('fc_mappingcode', $fc_mappingcode_decode)
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                    ->whereJsonContains('fc_credit_previledge', 'ONCE')
                    ->first();

                    if ($mappingRecord) {
                        $totalNominal = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                                        ->where('fc_statuspos', 'D')
                                        ->where('fc_branch', auth()->user()->fc_branch)
                                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                        ->sum('fm_nominal');
                        // $totalNominal += $request->nominal;
                        TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                                                ->where('fc_statuspos', 'C')
                                                ->update(['fm_nominal' => $totalNominal]);
                        // dd($totalNominal);
                    }
                }
                DB::commit(); 
                return [
                    'status' => 200,
                    'message' => 'Data berhasil disimpan'
                ];
            }else{
                DB::rollback(); 
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];
            }
        } catch (\Exception $e) {
            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function store_invoice(Request $request){
        DB::beginTransaction();
    
        try {
            $fc_docreference = base64_decode($request->fc_docreference);
            $fc_mappingcode_decode = base64_decode($request->fc_mappingcode);
            $validator = Validator::make($request->all(), [
                'fc_invno' => 'required',
                'nominal' => 'required',
                'fc_docreference' => 'required',
                'fc_mappingcode' => 'required'
            ]);
    
            if($validator->fails()) {
                return [
                    'status' => 300,
                    'message' => $validator->errors()->first()
                ];
            }

            $cek_exist = TempTrxAccountingDetail::where('fv_description', $request->fc_invno)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->count();

            if($cek_exist > 0){
                return [
                    'status' => 300,
                    'message' => 'No.Invoice sudah tersedia'
                ];
            }
    
            $temp_detail = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)->orderBy('fn_rownum', 'DESC')->first();
            $fn_rownum = 1;
            if (!empty($temp_detail)) {
                $fn_rownum = $temp_detail->fn_rownum + 1;
            }
            
            $fc_paymentmethod = 'NON';
            $fc_directpayment = DB::table('t_coa')
                                ->where('fc_coacode', '130.131')
                                ->value('fc_directpayment');
            if($fc_directpayment == 'F'){
                $fc_paymentmethod = 'NON';
            }else{
                $fc_paymentmethod = 'TRANS';
            }

            $insert = TempTrxAccountingDetail::create([
                'fc_branch' => auth()->user()->fc_branch,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_trxno' => auth()->user()->fc_userid,
                'fn_rownum' => $fn_rownum,
                'fc_coacode' => '130.131.' . $fc_docreference,
                'fc_statuspos' => $request->reference_invoice,
                'fm_nominal' => $request->nominal,
                'fc_paymentmethod' => $fc_paymentmethod,
                'fv_description' => $request->fc_invno,
                'created_by' => auth()->user()->fc_userid
            ]);
    
            if($insert){
                if ($request->reference_invoice == 'C') {
                    $mappingRecord = MappingMaster::where('fc_mappingcode', $fc_mappingcode_decode)
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                        ->whereJsonContains('fc_debit_previledge', 'ONCE')
                        ->first();
    
                        if ($mappingRecord) {
                            $totalNominal = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                                            ->where('fc_statuspos', 'C')
                                            ->where('fc_branch', auth()->user()->fc_branch)
                                            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                            ->sum('fm_nominal');
                            // $totalNominal += $request->nominal;
                            TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                                                    ->where('fc_statuspos', 'D')
                                                    ->where('fc_branch', auth()->user()->fc_branch)
                                                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                                    ->update(['fm_nominal' => $totalNominal]);
                        }
                }else{
                    $mappingRecord = MappingMaster::where('fc_mappingcode', $fc_mappingcode_decode)
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                    ->whereJsonContains('fc_credit_previledge', 'ONCE')
                    ->first();

                    if ($mappingRecord) {
                        $totalNominal = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                                        ->where('fc_statuspos', 'D')
                                        ->where('fc_branch', auth()->user()->fc_branch)
                                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                        ->sum('fm_nominal');
                        // $totalNominal += $request->nominal;
                        TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                                                ->where('fc_statuspos', 'C')
                                                ->where('fc_branch', auth()->user()->fc_branch)
                                                ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                                ->update(['fm_nominal' => $totalNominal]);
                    }
                }
                DB::commit(); 
                return [
                    'status' => 200,
                    'message' => 'Data berhasil disimpan'
                ];
            }else{
                DB::rollback(); 
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];
            }
        } catch (\Exception $e) {
            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    // Edit Transaksi
    public function store_bpb_edit(Request $request){
        $decode_fc_trxno = base64_decode($request->fc_trxno);

        DB::beginTransaction();
    
        try {
            $fc_docreference = base64_decode($request->fc_docreference);
            $fc_mappingcode_decode = base64_decode($request->fc_mappingcode);
            $validator = Validator::make($request->all(), [
                'fc_invno' => 'required',
                'nominal' => 'required',
                'fc_docreference' => 'required'
            ]);
    
            if($validator->fails()) {
                return [
                    'status' => 300,
                    'message' => $validator->errors()->first()
                ];
            }
            $cek_exist = TrxAccountingDetail::where('fv_description', $request->fc_invno)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->count();

            if($cek_exist > 0){
                return [
                    'status' => 300,
                    'message' => 'No.Invoice sudah tersedia'
                ];
            }
    
            $detail = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)->orderBy('fn_rownum', 'DESC')->first();
            $fn_rownum = 1;
            if (!empty($detail)) {
                $fn_rownum = $detail->fn_rownum + 1;
            }
            
            $fc_paymentmethod = 'NON';
            $fc_directpayment = DB::table('t_coa')
                                ->where('fc_coacode', '310.311')
                                ->value('fc_directpayment');
            if($fc_directpayment == 'F'){
                $fc_paymentmethod = 'NON';
            }else{
                $fc_paymentmethod = 'TRANS';
            }

            $insert = TrxAccountingDetail::create([
                'fc_branch' => auth()->user()->fc_branch,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_trxno' => $decode_fc_trxno,
                'fn_rownum' => $fn_rownum,
                'fc_coacode' => '310.311.' . $fc_docreference,
                'fc_statuspos' => $request->reference_bpb,
                'fm_nominal' => $request->nominal,
                'fc_paymentmethod' => $fc_paymentmethod,
                'fv_description' => $request->fc_invno,
                'created_by' => auth()->user()->fc_userid
            ]);
    
            if($insert){
                if ($request->reference_bpb == 'C') {
                    $mappingRecord = MappingMaster::where('fc_mappingcode', $fc_mappingcode_decode)
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                        ->whereJsonContains('fc_debit_previledge', 'ONCE')
                        ->first();
    
                        if ($mappingRecord) {
                            $totalNominal = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                                            ->where('fc_statuspos', 'C')
                                            ->where('fc_branch', auth()->user()->fc_branch)
                                            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                            ->sum('fm_nominal');
                            // $totalNominal += $request->nominal;
                            TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                                                    ->where('fc_statuspos', 'D')
                                                    ->update(['fm_nominal' => $totalNominal]);
                        }
                }else{
                    $mappingRecord = MappingMaster::where('fc_mappingcode', $fc_mappingcode_decode)
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                    ->whereJsonContains('fc_credit_previledge', 'ONCE')
                    ->first();

                    if ($mappingRecord) {
                        $totalNominal = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                                        ->where('fc_statuspos', 'D')
                                        ->where('fc_branch', auth()->user()->fc_branch)
                                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                        ->sum('fm_nominal');
                        // $totalNominal += $request->nominal;
                        TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                                                ->where('fc_statuspos', 'C')
                                                ->update(['fm_nominal' => $totalNominal]);
                        // dd($totalNominal);
                    }
                }
                DB::commit(); 
                return [
                    'status' => 200,
                    'message' => 'Data berhasil disimpan'
                ];
            }else{
                DB::rollback(); 
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];
            }
        } catch (\Exception $e) {
            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function store_invoice_edit(Request $request){
        $decode_fc_trxno = base64_decode($request->fc_trxno);
        DB::beginTransaction();
    
        try {
            $fc_docreference = base64_decode($request->fc_docreference);
            $fc_mappingcode_decode = base64_decode($request->fc_mappingcode);
            $validator = Validator::make($request->all(), [
                'fc_invno' => 'required',
                'nominal' => 'required',
                'fc_docreference' => 'required'
            ]);
    
            if($validator->fails()) {
                return [
                    'status' => 300,
                    'message' => $validator->errors()->first()
                ];
            }
            $cek_exist = TrxAccountingDetail::where('fv_description', $request->fc_invno)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->count();

            if($cek_exist > 0){
                return [
                    'status' => 300,
                    'message' => 'No.Invoice sudah tersedia'
                ];
            }
    
            $detail = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)->orderBy('fn_rownum', 'DESC')->first();
            $fn_rownum = 1;
            if (!empty($detail)) {
                $fn_rownum = $detail->fn_rownum + 1;
            }
            
            $fc_paymentmethod = 'NON';
            $fc_directpayment = DB::table('t_coa')
                                ->where('fc_coacode', '130.131')
                                ->value('fc_directpayment');
            if($fc_directpayment == 'F'){
                $fc_paymentmethod = 'NON';
            }else{
                $fc_paymentmethod = 'TRANS';
            }

            $insert = TrxAccountingDetail::create([
                'fc_branch' => auth()->user()->fc_branch,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_trxno' => $decode_fc_trxno,
                'fn_rownum' => $fn_rownum,
                'fc_coacode' => '130.131.' . $fc_docreference,
                'fc_statuspos' => $request->reference_invoice,
                'fm_nominal' => $request->nominal,
                'fc_paymentmethod' => $fc_paymentmethod,
                'fv_description' => $request->fc_invno,
                'created_by' => auth()->user()->fc_userid
            ]);
    
            if($insert){
                if ($request->reference_invoice == 'C') {
                    $mappingRecord = MappingMaster::where('fc_mappingcode', $fc_mappingcode_decode)
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                        ->whereJsonContains('fc_debit_previledge', 'ONCE')
                        ->first();
    
                        if ($mappingRecord) {
                            $totalNominal = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                                            ->where('fc_statuspos', 'C')
                                            ->where('fc_branch', auth()->user()->fc_branch)
                                            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                            ->sum('fm_nominal');
                            // $totalNominal += $request->nominal;
                            TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                                                    ->where('fc_statuspos', 'D')
                                                    ->update(['fm_nominal' => $totalNominal]);
                        }
                }else{
                    $mappingRecord = MappingMaster::where('fc_mappingcode', $fc_mappingcode_decode)
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                    ->whereJsonContains('fc_credit_previledge', 'ONCE')
                    ->first();

                    if ($mappingRecord) {
                        $totalNominal = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                                        ->where('fc_statuspos', 'D')
                                        ->where('fc_branch', auth()->user()->fc_branch)
                                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                        ->sum('fm_nominal');
                        // $totalNominal += $request->nominal;
                        TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                                                ->where('fc_statuspos', 'C')
                                                ->update(['fm_nominal' => $totalNominal]);
                        // dd($totalNominal);
                    }
                }
                DB::commit(); 
                return [
                    'status' => 200,
                    'message' => 'Data berhasil disimpan'
                ];
            }else{
                DB::rollback(); 
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];
            }
        } catch (\Exception $e) {
            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function store_kredit(Request $request){
        DB::beginTransaction();
    
        try {
            $validator = Validator::make($request->all(), [
                'fc_coacode_kredit' => 'required',
                'fc_paymentmethod_kredit' => 'required',
            ]);
    
            if($validator->fails()) {
                return [
                    'status' => 300,
                    'message' => $validator->errors()->first()
                ];
            }
    
            $temp_detail = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)->orderBy('fn_rownum', 'DESC')->first();
            $fn_rownum = 1;
            if (!empty($temp_detail)) {
                $fn_rownum = $temp_detail->fn_rownum + 1;
            }
    
           
            $insert_kredit = TempTrxAccountingDetail::create([
                'fc_branch' => auth()->user()->fc_branch,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_trxno' => auth()->user()->fc_userid,
                'fc_coacode' => $request->fc_coacode_kredit,
                'fn_rownum' => $fn_rownum,
                'fc_statuspos' => 'C',
                'fc_paymentmethod' => $request->fc_paymentmethod_kredit,
                'fc_refno' => ($request->fc_refno_kredit === '') ? NULL : $request->fc_refno_kredit,
                'fd_agingref' => ($request->fd_agingref_kredit === '') ? NULL : $request->fd_agingref_kredit,
                'created_by' => auth()->user()->fc_userid
            ]);
    
            if($insert_kredit){
                DB::commit(); 
                return [
                    'status' => 200,
                    'message' => 'Data berhasil disimpan'
                ];
            }else{
                DB::rollback();
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];
            }
        } catch (\Exception $e) {
            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function edit_debit(Request $request, string $fc_trxno){
        DB::beginTransaction();
    
        try {
            $decode_fc_trxno = base64_decode($fc_trxno);
            $validator = Validator::make($request->all(), [
                'fc_coacode' => 'required',
                'fc_paymentmethod' => 'required',
            ]);
    
            if($validator->fails()) {
                return [
                    'status' => 300,
                    'message' => $validator->errors()->first()
                ];
            }
    
            $temp_detail = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)->orderBy('fn_rownum', 'DESC')->first();
            $fn_rownum = 1;
            if (!empty($temp_detail)) {
                $fn_rownum = $temp_detail->fn_rownum + 1;
            }
    
            $insert_debit = TrxAccountingDetail::create([
                'fc_branch' => auth()->user()->fc_branch,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_trxno' => $decode_fc_trxno,
                'fn_rownum' => $fn_rownum,
                'fc_coacode' => $request->fc_coacode,
                'fc_statuspos' => 'D',
                'fc_paymentmethod' => $request->fc_paymentmethod,
                'fc_refno' => ($request->fc_refno === '') ? NULL : $request->fc_refno,
                'fd_agingref' => ($request->fd_agingref === '') ? NULL : $request->fd_agingref,
                'created_by' => auth()->user()->fc_userid
            ]);

            if($insert_debit){
                DB::commit(); 
                return [
                    'status' => 200,
                    'message' => 'Data berhasil disimpan'
                ];
            }else{
                DB::rollback(); 
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];  
            }
        } catch (\Exception $e) {
            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function edit_kredit(Request $request, string $fc_trxno){
        DB::beginTransaction();
    
        try {
            $decode_fc_trxno = base64_decode($fc_trxno);
            $validator = Validator::make($request->all(), [
                'fc_coacode_kredit' => 'required',
                'fc_paymentmethod_kredit' => 'required',
            ]);
    
            if($validator->fails()) {
                return [
                    'status' => 300,
                    'message' => $validator->errors()->first()
                ];
            }
    
            $temp_detail = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)->orderBy('fn_rownum', 'DESC')->first();
            $fn_rownum = 1;
            if (!empty($temp_detail)) {
                $fn_rownum = $temp_detail->fn_rownum + 1;
            }
    
            $insert_kredit = TrxAccountingDetail::create([
                'fc_branch' => auth()->user()->fc_branch,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_trxno' => $decode_fc_trxno,
                'fc_coacode' => $request->fc_coacode_kredit,
                'fn_rownum' => $fn_rownum,
                'fc_statuspos' => 'C',
                'fc_paymentmethod' => $request->fc_paymentmethod_kredit,
                'fc_refno' => ($request->fc_refno_kredit === '') ? NULL : $request->fc_refno_kredit,
                'fd_agingref' => ($request->fd_agingref_kredit === '') ? NULL : $request->fd_agingref_kredit,
                'created_by' => auth()->user()->fc_userid
            ]);

            if($insert_kredit){
                DB::commit(); 
                return [
                    'status' => 200,
                    'message' => 'Data berhasil disimpan'
                ];
            }else{
                DB::rollback(); 
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];  
            }
        } catch (\Exception $e) {
            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function update_edit_debit_transaksi(Request $request, string $fc_trxno){
        $decode_fc_trxno = base64_decode($fc_trxno);
        $validator = Validator::make($request->all(), [
            'fn_rownum' => 'required',
            'fc_mappingcode' => 'required'
        ]);
    
        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
        
        $decode_fc_mappingcode = base64_decode($request->fc_mappingcode);
        $invtrx = $this->validateAndUpdateInvoiceEdit($request, $decode_fc_trxno);
        if (is_array($invtrx)) {
            return $invtrx;
        }

        $invtrxBpb = $this->validateAndUpdateInvoiceBpbEdit($request, $decode_fc_trxno);
        if (is_array($invtrxBpb)) {
            return $invtrxBpb;
        } 
        
    
        DB::beginTransaction();
    
        try {
            // Jika $request->fc_credit_previledge array kosong
            if (empty($request->fc_debit_previledge)){
                return [
                    'status' => 300,
                    'message' => 'Tidak terdapat transaksi method previledge'
                ];
            }
    
            $updateDescription = true;
            $updateNominal = true;
    
            // Cek kondisi berdasarkan isi fc_credit_previledge
            if (in_array('DESC', json_decode($request->fc_debit_previledge))) {
                $updateDescription = false;
            }
    
            if (in_array('VALUE', json_decode($request->fc_debit_previledge))) {
                $updateNominal = false;
            }
    
            // Update data pada TrxAccountingDetail dengan fc_statuspos 'D'
            $updateDataC = [
                'updated_by' => auth()->user()->fc_userid
            ];
    
            if ($updateNominal && strpos($request->fm_nominal, 'Rp') === false) {
                $updateDataC['fm_nominal'] = Convert::convert_to_double($request->fm_nominal);
            }
    
            if ($updateDescription) {
                $updateDataC['fv_description'] = $request->fv_description;
            }
    
            $updateD = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                ->where('fn_rownum', $request->fn_rownum)
                ->where('fc_statuspos', 'D')
                ->update($updateDataC);
    
            if ($updateD) {
                $previledge = MappingMaster::where('fc_mappingcode', $decode_fc_mappingcode)
                                                  ->where('fc_branch', auth()->user()->fc_branch)
                                                  ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                                  ->first();
                if (in_array('ONCE', json_decode($previledge->fc_credit_previledge))) {
                    // Hitung jumlah nominal dari baris dengan fc_trxno yang sama dan fc_statuspos 'C'
                    $totalNominalDLama = doubleval(TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                        ->where('fn_rownum', '!=', $request->fn_rownum) // kecuali fn_rownum request
                        ->where('fc_statuspos', 'D')
                        ->sum('fm_nominal'));
                    
                    $updateDataC = [
                        'updated_by' => auth()->user()->fc_userid
                    ];
                    
                    if ($updateNominal) {
                        $updateDataC['fm_nominal'] = $totalNominalDLama + Convert::convert_to_double($request->fm_nominal);
                    }
                    
                    // Update semua baris dengan fc_trxno yang sama dan fc_statuspos 'D' dengan total nominal dari 'C'
                    $updateC = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                        ->where('fc_statuspos', 'C')
                        ->update($updateDataC);
                    
                    if ($updateC) {
                        DB::commit();
                        return [
                            'status' => 200,
                            'message' => 'Data berhasil diubah'
                        ];
                    } else {
                        DB::rollback();
                        return [
                            'status' => 300,
                            'message' => 'Data gagal diubah'
                        ];
                    }
                } else {
                    DB::commit();
                    return [
                        'status' => 200,
                        'message' => 'Data berhasil diubah'
                    ];
                }
            } else {
                DB::rollback();
                return [
                    'status' => 300,
                    'message' => 'Data gagal diubah'
                ];
            }
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function update_edit_kredit_transaksi(Request $request, string $fc_trxno){
        $decode_fc_trxno = base64_decode($fc_trxno);
        // validator
         // validator
         $validator = Validator::make($request->all(), [
            'fn_rownum' => 'required',
            'fc_mappingcode' => 'required'
        ]);
    
        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
    
        
        $decode_fc_mappingcode = base64_decode($request->fc_mappingcode);
        $invtrx = $this->validateAndUpdateInvoiceEdit($request, $decode_fc_trxno);
        if (is_array($invtrx)) {
            return $invtrx;
        } 

        $invtrxBpb = $this->validateAndUpdateInvoiceBpbEdit($request, $decode_fc_trxno);
        if (is_array($invtrxBpb)) {
            return $invtrxBpb;
        } 
    
        DB::beginTransaction();
    
        try {
            // Jika $request->fc_credit_previledge array kosong
            if (empty($request->fc_credit_previledge)){
                return [
                    'status' => 300,
                    'message' => 'Tidak terdapat transaksi method previledge'
                ];
            }
    
            $updateDescription = true;
            $updateNominal = true;
    
            // Cek kondisi berdasarkan isi fc_credit_previledge
            if (in_array('DESC', json_decode($request->fc_credit_previledge))) {
                $updateDescription = false;
            }
    
            if (in_array('VALUE', json_decode($request->fc_credit_previledge))) {
                $updateNominal = false;
            }
    
            // Update data pada TempTrxAccountingDetail dengan fc_statuspos 'C'
            $updateDataC = [
                'updated_by' => auth()->user()->fc_userid
            ];
    
            if ($updateNominal && strpos($request->fm_nominal, 'Rp') === false) {
                $updateDataC['fm_nominal'] = Convert::convert_to_double($request->fm_nominal);
            }
    
            if ($updateDescription) {
                $updateDataC['fv_description'] = $request->fv_description;
            }
    
            $updateC = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                ->where('fn_rownum', $request->fn_rownum)
                ->where('fc_statuspos', 'C')
                ->update($updateDataC);
    
            if ($updateC) {
                $previledge = MappingMaster::where('fc_mappingcode', $decode_fc_mappingcode)
                                                  ->where('fc_branch', auth()->user()->fc_branch)
                                                  ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                                  ->first();
                if (in_array('ONCE', json_decode($previledge->fc_debit_previledge))) {
                    // Hitung jumlah nominal dari baris dengan fc_trxno yang sama dan fc_statuspos 'C'
                    $totalNominalCLama = doubleval(TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                        ->where('fn_rownum', '!=', $request->fn_rownum) // kecuali fn_rownum request
                        ->where('fc_statuspos', 'C')
                        ->sum('fm_nominal'));
                    
                    $updateDataD = [
                        'updated_by' => auth()->user()->fc_userid
                    ];
                    
                    if ($updateNominal) {
                        $updateDataD['fm_nominal'] = $totalNominalCLama + Convert::convert_to_double($request->fm_nominal);
                    }
                    
                    // Update semua baris dengan fc_trxno yang sama dan fc_statuspos 'D' dengan total nominal dari 'C'
                    $updateD = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                        ->where('fc_statuspos', 'D')
                        ->update($updateDataD);
                    
                    if ($updateD) {
                        DB::commit();
                        return [
                            'status' => 200,
                            'message' => 'Data berhasil diubah'
                        ];
                    } else {
                        DB::rollback();
                        return [
                            'status' => 300,
                            'message' => 'Data gagal diubah'
                        ];
                    }
                } else {
                    DB::commit();
                    return [
                        'status' => 200,
                        'message' => 'Data berhasil diubah'
                    ];
                }
            } else {
                DB::rollback();
                return [
                    'status' => 300,
                    'message' => 'Data gagal diubah'
                ];
            }
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function update_debit_transaksi(Request $request){
         // validator
         $validator = Validator::make($request->all(), [
            'fn_rownum' => 'required',
            'fc_mappingcode' => 'required'
        ]);
    
        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
        
        $decode_fc_mappingcode = base64_decode($request->fc_mappingcode);
        $invtrx = $this->validateAndUpdateInvoice($request);
        if (is_array($invtrx)) {
            return $invtrx;
        } 

        $invtrxBpb = $this->validateAndUpdateInvoiceBpb($request);
        if (is_array($invtrxBpb)) {
            return $invtrxBpb;
        } 
    
        DB::beginTransaction();
    
        try {
            // Jika $request->fc_credit_previledge array kosong
            if (empty($request->fc_debit_previledge)){
                return [
                    'status' => 300,
                    'message' => 'Tidak terdapat transaksi method previledge'
                ];
            }
    
            $updateDescription = true;
            $updateNominal = true;
    
            // Cek kondisi berdasarkan isi fc_credit_previledge
            if (in_array('DESC', json_decode($request->fc_debit_previledge))) {
                $updateDescription = false;
            }
    
            if (in_array('VALUE', json_decode($request->fc_debit_previledge))) {
                $updateNominal = false;
            }
    
            // Update data pada TempTrxAccountingDetail dengan fc_statuspos 'D'
            $updateDataC = [
                'updated_by' => auth()->user()->fc_userid
            ];
    
            if ($updateNominal && strpos($request->fm_nominal, 'Rp') === false) {
                $updateDataC['fm_nominal'] = Convert::convert_to_double($request->fm_nominal);
            }
    
            if ($updateDescription) {
                $updateDataC['fv_description'] = $request->fv_description;
            }
    
            $updateD = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                ->where('fn_rownum', $request->fn_rownum)
                ->where('fc_statuspos', 'D')
                ->update($updateDataC);
    
            if ($updateD) {
                $previledge = MappingMaster::where('fc_mappingcode', $decode_fc_mappingcode)
                                                  ->where('fc_branch', auth()->user()->fc_branch)
                                                  ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                                  ->first();
                if (in_array('ONCE', json_decode($previledge->fc_credit_previledge))) {
                    // Hitung jumlah nominal dari baris dengan fc_trxno yang sama dan fc_statuspos 'C'
                    $totalNominalDLama = doubleval(TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                        ->where('fn_rownum', '!=', $request->fn_rownum) // kecuali fn_rownum request
                        ->where('fc_statuspos', 'D')
                        ->sum('fm_nominal'));
                    
                    $updateDataC = [
                        'updated_by' => auth()->user()->fc_userid
                    ];
                    
                    if ($updateNominal) {
                        $updateDataC['fm_nominal'] = $totalNominalDLama + Convert::convert_to_double($request->fm_nominal);
                    }
                    
                    // Update semua baris dengan fc_trxno yang sama dan fc_statuspos 'D' dengan total nominal dari 'C'
                    $updateC = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                        ->where('fc_statuspos', 'C')
                        ->update($updateDataC);
                    
                    if ($updateC) {
                        DB::commit();
                        return [
                            'status' => 200,
                            'message' => 'Data berhasil diubah'
                        ];
                    } else {
                        DB::rollback();
                        return [
                            'status' => 300,
                            'message' => 'Data gagal diubah'
                        ];
                    }
                } else {
                    DB::commit();
                    return [
                        'status' => 200,
                        'message' => 'Data berhasil diubah'
                    ];
                }
            } else {
                DB::rollback();
                return [
                    'status' => 300,
                    'message' => 'Data gagal diubah'
                ];
            }
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function update_kredit_transaksi(Request $request){
        // validator
        $validator = Validator::make($request->all(), [
            'fn_rownum' => 'required',
            'fc_mappingcode' => 'required'
        ]);
    
        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
    
        
        $decode_fc_mappingcode = base64_decode($request->fc_mappingcode);
        $invtrx = $this->validateAndUpdateInvoice($request);
    
        if (is_array($invtrx)) {
            return $invtrx;
        } 

        $invtrxBpb = $this->validateAndUpdateInvoiceBpb($request);
        if (is_array($invtrxBpb)) {
            return $invtrxBpb;
        } 
    
        DB::beginTransaction();
    
        try {
            // Jika $request->fc_credit_previledge array kosong
            if (empty($request->fc_credit_previledge)){
                return [
                    'status' => 300,
                    'message' => 'Tidak terdapat transaksi method previledge'
                ];
            }
    
            $updateDescription = true;
            $updateNominal = true;
    
            // Cek kondisi berdasarkan isi fc_credit_previledge
            if (in_array('DESC', json_decode($request->fc_credit_previledge))) {
                $updateDescription = false;
            }
    
            if (in_array('VALUE', json_decode($request->fc_credit_previledge))) {
                $updateNominal = false;
            }
    
            // Update data pada TempTrxAccountingDetail dengan fc_statuspos 'C'
            $updateDataC = [
                'updated_by' => auth()->user()->fc_userid
            ];
    
            if ($updateNominal && strpos($request->fm_nominal, 'Rp') === false) {
                $updateDataC['fm_nominal'] = Convert::convert_to_double($request->fm_nominal);
            }
    
            if ($updateDescription) {
                $updateDataC['fv_description'] = $request->fv_description;
            }
    
            $updateC = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                ->where('fn_rownum', $request->fn_rownum)
                ->where('fc_statuspos', 'C')
                ->update($updateDataC);
    
            if ($updateC) {
                $previledge = MappingMaster::where('fc_mappingcode', $decode_fc_mappingcode)
                                                  ->where('fc_branch', auth()->user()->fc_branch)
                                                  ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                                                  ->first();
                if (in_array('ONCE', json_decode($previledge->fc_debit_previledge))) {
                    // Hitung jumlah nominal dari baris dengan fc_trxno yang sama dan fc_statuspos 'C'
                    $totalNominalCLama = doubleval(TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                                            ->where('fn_rownum', '!=', $request->fn_rownum)
                                            ->where('fc_statuspos', 'C')
                                            ->sum('fm_nominal'));
                    
                    $updateDataD = [
                        'updated_by' => auth()->user()->fc_userid
                    ];
                    
                    if ($updateNominal) {
                        $updateDataD['fm_nominal'] = $totalNominalCLama + Convert::convert_to_double($request->fm_nominal);
                        // dd($totalNominalCLama);
                    }
                    
                    // Update semua baris dengan fc_trxno yang sama dan fc_statuspos 'D' dengan total nominal dari 'C'
                    $updateD = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                        ->where('fc_statuspos', 'D')
                        ->update($updateDataD);
                    
                    if ($updateD) {
                        DB::commit();
                        return [
                            'status' => 200,
                            'message' => 'Data berhasil diubah'
                        ];
                    } else {
                        DB::rollback();
                        return [
                            'status' => 300,
                            'message' => 'Data gagal diubah'
                        ];
                    }
                } else {
                    DB::commit();
                    return [
                        'status' => 200,
                        'message' => 'Data berhasil diubah'
                    ];
                }
            } else {
                DB::rollback();
                return [
                    'status' => 300,
                    'message' => 'Data gagal diubah'
                ];
            }
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }    

    public function submit_transaksi(Request $request){
        // validator
        $validator = Validator::make($request->all(), [
            'status_balance' => 'required',
            'tipe_jurnal' => 'required',
            'jumlah_balance' => 'required'
        ], [
            'status_balance.required' => 'Nominal Debit dan Kredit masih 0',
            'jumlah_balance.required' => 'Debit dan Kredit belum Balance, '
        ]);
    
        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        DB::beginTransaction();
        try {
            // Fetch TempTrxAccountingMaster
            $temp_master = TempTrxAccountingMaster::where('fc_trxno', auth()->user()->fc_userid)
                ->where('fc_branch', auth()->user()->fc_branch)->first();
    
            // Fetch InvMaster
            $invmst = InvMaster::where('fc_invno', $temp_master->fc_docreference)
                ->where('fc_branch', auth()->user()->fc_branch)->first();
    
            // Fetch temp detail count
            $exist_detail = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                ->where('fm_nominal', '!=', 0)
                ->where('fc_branch', auth()->user()->fc_branch)
                ->count();
    
            if ($exist_detail < 1) {
                throw new \Exception('Oops! Item debit atau kredit tidak boleh kosong');
            } else if ($request->status_balance == 'false') {
                throw new \Exception('Oops! Gagal submit karena tidak balance');
            } else {
                if ($request->tipe_jurnal == 'LREF') {
                    if ($request->jumlah_balance > ($invmst->fm_brutto - $invmst->fm_paidvalue)) {
                        throw new \Exception('Oops! Balance Transaksi melebihi tagihan yang tertera');
                    }
                }
    
                // Update TempTrxAccountingMaster
                $update = TempTrxAccountingMaster::where('fc_trxno', auth()->user()->fc_userid)
                    ->where('fc_branch', auth()->user()->fc_branch)->update([
                        'fc_status' => 'F',
                        'fv_description' => $request->fv_description_submit
                    ]);

                // Delete temp detail and master
                TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                    ->where('fc_branch', auth()->user()->fc_branch)->delete();
                TempTrxAccountingMaster::where('fc_trxno', auth()->user()->fc_userid)
                    ->where('fc_branch', auth()->user()->fc_branch)->delete();
    
                if (!$update) {
                    throw new \Exception('Oops! Gagal submit');
                }
    
                DB::commit();
    
                return [
                    'status' => 201,
                    'message' => 'Submit Berhasil',
                    'link' => '/apps/transaksi'
                ];
            }
        } catch (\Exception $e) {
            DB::rollback();
    
            // Return error response
            return [
                'status' => 300,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function submit_edit(Request $request, string $fc_trxno){
        $decode_fc_trxno = base64_decode($fc_trxno);
        // validator
        $validator = Validator::make($request->all(), [
            'status_balance' => 'required',
            'tipe_jurnal' => 'required',
            'jumlah_balance' => 'required'
        ], [
            'status_balance.required' => 'Nominal Debit dan Kredit masih 0',
            'jumlah_balance.required' => 'Debit dan Kredit belum Balance, '
        ]);
    
        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
    
        DB::beginTransaction();
        try {
            // Fetch TempTrxAccountingMaster
            $temp_master = TrxAccountingMaster::where('fc_trxno', $decode_fc_trxno)
                ->where('fc_branch', auth()->user()->fc_branch)->first();
    
            // Fetch InvMaster
            $invmst = InvMaster::where('fc_invno', $temp_master->fc_docreference)
                ->where('fc_branch', auth()->user()->fc_branch)->first();
    
            // Fetch temp detail count
            $exist_detail = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                ->where('fm_nominal', '!=', 0)
                ->where('fc_branch', auth()->user()->fc_branch)
                ->count();
    
            if ($exist_detail < 1) {
                throw new \Exception('Oops! Item debit atau kredit tidak boleh kosong');
            } else if ($request->status_balance == 'false') {
                throw new \Exception('Oops! Gagal submit karena tidak balance');
            } else {
                if ($request->tipe_jurnal == 'LREF') {
                    if ($request->jumlah_balance > ($invmst->fm_brutto - $invmst->fm_paidvalue)) {
                        throw new \Exception('Oops! Balance Transaksi melebihi tagihan yang tertera');
                    }
                }
    
                // Update TrxAccountingMaster
                $update = [TrxAccountingMaster::where('fc_trxno', $decode_fc_trxno)
                    ->where('fc_branch', auth()->user()->fc_branch)->update([
                        'fc_status' => 'F',
                    ]), Approvement::where('fc_trxno', $decode_fc_trxno)
                    ->where('fc_approvalstatus', 'A')
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->update([
                        'fc_approvalused' => 'T',
                    ])];
    
                if (!$update) {
                    throw new \Exception('Oops! Gagal submit');
                }
    
                DB::commit();
    
                return [
                    'status' => 201,
                    'message' => 'Submit Berhasil',
                    'link' => '/apps/transaksi'
                ];
            }
        } catch (\Exception $e) {
            DB::rollback();
    
            // Return error response
            return [
                'status' => 300,
                'message' => $e->getMessage(),
            ];
        }
    } 

    private function validateAndUpdateInvoice($request){
        if ($request->fv_description !== null && str_contains($request->fv_description, 'INV/')) {
            $invtrx = InvTrx::where('fc_invno', $request->fv_description)->first();
            if($invtrx){
                $currInv = TempTrxAccountingDetail::where([
                    'fc_trxno' => Auth()->user()->fc_userid,
                    'fn_rownum' => $request->fn_rownum,
                    'fc_branch' => Auth()->user()->fc_branch,
                    'fc_divisioncode' => Auth()->user()->fc_divisioncode
                ])->first();
    
                $totalPaid = $invtrx->fm_paidinvvalue + $invtrx->fm_paidtaxvalue;
                $totalInvoice = $invtrx->fm_invnetto + $invtrx->fm_taxvalue;
    
                // Convert Value Request to Correct type number 
                $currentNominal = str_replace(".", "", $request->fm_nominal);
                $currentNominal = str_replace(",", ".", $currentNominal);
                $currentNominal = (double) $currentNominal;
                
                if ($totalPaid + $currentNominal > $totalInvoice && (str_contains($currInv->fc_coacode, "310.311") || str_contains($currInv->fc_coacode, "130.131"))) {
                    return [
                        'status' => 300,
                        'message' => 'Data gagal diubah, karena melebihi total INV'
                    ];
                }
            }
        } else {
            $invtrx = null;
        }

        return $invtrx;
    }

    private function validateAndUpdateInvoiceEdit($request, $decode_fc_trxno){
        if ($request->fv_description !== null && str_contains($request->fv_description, 'INV/')) {
            $invtrx = InvTrx::where('fc_invno', $request->fv_description)->first();
            if($invtrx){
                $currInv = TrxAccountingDetail::where([
                    // 'fc_trxno' => $request->fc_trxno,
                    'fn_rownum' => $request->fn_rownum,
                    'fc_branch' => auth()->user()->fc_branch,
                    'fc_divisioncode' => auth()->user()->fc_divisioncode
                ])->first();
    
                $totalPaid = $invtrx->fm_paidinvvalue + $invtrx->fm_paidtaxvalue;
                $totalInvoice = $invtrx->fm_invnetto + $invtrx->fm_taxvalue;
    
                // Convert Value Request to Correct type number 
                $currentNominal = str_replace(".", "", $request->fm_nominal);
                $currentNominal = str_replace(",", ".", $currentNominal);
                $currentNominal = (double) $currentNominal;
                
                if ($totalPaid + $currentNominal > $totalInvoice && (str_contains($currInv->fc_coacode, "310.311") || str_contains($currInv->fc_coacode, "130.131"))) {
                    return [
                        'status' => 300,
                        'message' => 'Data gagal diubah, karena melebihi total INV'
                    ];
                }
                // dd($currInv);
            }
        } else {
            $invtrx = null;
        }

        return $invtrx;
    }

    private function validateAndUpdateInvoiceBpb($request){
        if ($request->fv_description !== null && str_contains($request->fv_description, 'BPB/')) {
            $invtrx = InvTrx::where('fc_invno', $request->fv_description)->first();
            if($invtrx){
                $currInv = TempTrxAccountingDetail::where([
                    'fc_trxno' => auth()->user()->fc_userid,
                    'fn_rownum' => $request->fn_rownum,
                    'fc_branch' => auth()->user()->fc_branch,
                    'fc_divisioncode' => auth()->user()->fc_divisioncode
                ])->first();
    
                $totalPaid = $invtrx->fm_paidinvvalue + $invtrx->fm_paidtaxvalue;
                $totalInvoice = $invtrx->fm_invnetto + $invtrx->fm_taxvalue;
    
                // Convert Value Request to Correct type number 
                $currentNominal = str_replace(".", "", $request->fm_nominal);
                $currentNominal = str_replace(",", ".", $currentNominal);
                $currentNominal = (double) $currentNominal;
                
                if ($totalPaid + $currentNominal > $totalInvoice && (str_contains($currInv->fc_coacode, "310.311") || str_contains($currInv->fc_coacode, "130.131"))) {
                    return [
                        'status' => 300,
                        'message' => 'Data gagal diubah, karena melebihi total INV BPB'
                    ];
                }
            }
        } else {
            $invtrx = null;
        }

        return $invtrx;
    }

    private function validateAndUpdateInvoiceBpbEdit($request, $decode_fc_trxno){
        if ($request->fv_description !== null && str_contains($request->fv_description, 'BPB/')) {
            $invtrx = InvTrx::where('fc_invno', $request->fv_description)->first();
            if($invtrx){
                $currInv = TrxAccountingDetail::where([
                    'fc_trxno' => $decode_fc_trxno,
                    'fn_rownum' => $request->fn_rownum,
                    'fc_branch' => auth()->user()->fc_branch,
                    'fc_divisioncode' => auth()->user()->fc_divisioncode
                ])->first();
    
                $totalPaid = $invtrx->fm_paidinvvalue + $invtrx->fm_paidtaxvalue;
                $totalInvoice = $invtrx->fm_invnetto + $invtrx->fm_taxvalue;
    
                // Convert Value Request to Correct type number 
                $currentNominal = str_replace(".", "", $request->fm_nominal);
                $currentNominal = str_replace(",", ".", $currentNominal);
                $currentNominal = (double) $currentNominal;
                
                if ($totalPaid + $currentNominal > $totalInvoice && (str_contains($currInv->fc_coacode, "310.311") || str_contains($currInv->fc_coacode, "130.131"))) {
                    return [
                        'status' => 300,
                        'message' => 'Data gagal diubah, karena melebihi total INV BPB'
                    ];
                }
            }
        } else {
            $invtrx = null;
        }

        return $invtrx;
    }

    
}
