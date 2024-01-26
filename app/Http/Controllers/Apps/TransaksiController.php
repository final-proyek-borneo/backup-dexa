<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\MappingMaster;
use App\Models\MappingDetail;
use Carbon\Carbon;
use App\Helpers\Convert;
use DB;
use App\Models\Giro;
use App\Models\TrxAccountingMaster;
use App\Models\TrxAccountingDetail;
use App\Models\TempTrxAccountingMaster;
use App\Models\TempTrxAccountingDetail;
use Validator;
use Auth;
use App\Helpers\ApiFormatter;
use App\Models\Approvement;
use App\Models\InvoiceMst;
use App\Models\MappingUser;
use App\Models\TempSuppTrxAcc;
use App\Models\SuppTrxAcc;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransaksiController extends Controller
{

    public function index()
    {
        return view('apps.transaksi.index');
    }

    public function bookmark_index()
    {
        return view('apps.transaksi.bookmark-index');
    }

    public function giro()
    {
        return view('apps.transaksi.giro');
    }

    public function opsi_lanjutan()
    {
        $data['data'] = TempTrxAccountingMaster::with('transaksitype', 'mapping', 'branch', 'temptrxaccountingdtl.coamst')->where('fc_trxno', auth()->user()->fc_userid)->first();
        $get_mappingcode = TempTrxAccountingMaster::where('fc_trxno', auth()->user()->fc_userid)
            ->where('fc_branch', auth()->user()->fc_branch)->first()->fc_mappingcode;



        $statusposcredit = MappingMaster::where('fc_mappingcode', $get_mappingcode)
            ->where('fc_branch', auth()->user()->fc_branch)->first()->fc_credit_previledge;
        // $statusposcredit array of string json terdapat value 'ONCE' maka value 'C' selain itu 'D'
        $statuspos = in_array('ONCE', json_decode($statusposcredit)) ? 'C' : 'D';

        $coa = TempTrxAccountingDetail::with('coamst')->where('fc_trxno', auth()->user()->fc_userid)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_statuspos', $statuspos)->first();
        $data['coa'] = $coa;
        return view('apps.transaksi.opsi-lanjutan', $data);
        // dd($coa);
    }

    public function edit($fc_trxno)
    {
        $decode_fc_trxno = base64_decode($fc_trxno);
        session(['fc_trxno_global' => $decode_fc_trxno]);
        $data['data'] = TrxAccountingMaster::with('transaksitype', 'mapping')->where('fc_trxno', $decode_fc_trxno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['fc_trxno'] = $decode_fc_trxno;
        return view('apps.transaksi.edit', $data);
    }

    public function edit_opsi($fc_trxno)
    {
        $decode_fc_trxno = base64_decode($fc_trxno);
        session(['fc_trxno_global' => $decode_fc_trxno]);
        $data['data'] = TrxAccountingMaster::with('transaksitype', 'mapping')->where('fc_trxno', $decode_fc_trxno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['fc_trxno'] = $decode_fc_trxno;
        $get_mappingcode = TrxAccountingMaster::where('fc_trxno', $decode_fc_trxno)
            ->where('fc_branch', auth()->user()->fc_branch)->first()->fc_mappingcode;

        $statusposcredit = MappingMaster::where('fc_mappingcode', $get_mappingcode)
            ->where('fc_branch', auth()->user()->fc_branch)->first()->fc_credit_previledge;
        // $statusposcredit array of string json terdapat value 'ONCE' maka value 'C' selain itu 'D'
        $statuspos = in_array('ONCE', json_decode($statusposcredit)) ? 'C' : 'D';

        $coa = TrxAccountingDetail::with('coamst')->where('fc_trxno', $decode_fc_trxno)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_statuspos', $statuspos)->first();

        $data['coa'] = $coa;

        return view('apps.transaksi.edit-opsi', $data);
    }

    public function detail($fc_trxno)
    {
        $decode_fc_trxno = base64_decode($fc_trxno);
        session(['fc_trxno_global' => $decode_fc_trxno]);
        $data['data'] = TrxAccountingMaster::with('transaksitype', 'mapping')->where('fc_trxno', $decode_fc_trxno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['supp'] = SuppTrxAcc::with('coamst', 'payment')->where('fc_trxno', $decode_fc_trxno)->where('fc_branch', auth()->user()->fc_branch)->count();
        $data['fc_trxno'] = $decode_fc_trxno;
        return view('apps.transaksi.detail', $data);
        // dd($data);
    }

    public function create()
    {
        $temp_trxaccounting_mst = TempTrxAccountingMaster::with('transaksitype', 'mapping', 'branch')->where('fc_trxno', auth()->user()->fc_userid)->first();
        $temp_trxaccounting_dtl = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)->get();

        $total = count($temp_trxaccounting_dtl);
        if (!empty($temp_trxaccounting_mst)) {
            $data['data'] = $temp_trxaccounting_mst;
            $data['total'] = $total;
            return view('apps.transaksi.create-detail', $data);
            // dd($data);
        }
        return view('apps.transaksi.create-index');
    }

    public function get_detail($fc_mappingcode)
    {
        $mappingcode = base64_decode($fc_mappingcode);

        $data = MappingMaster::with('tipe', 'transaksi')
            ->where([
                'fc_mappingcode' =>  $mappingcode,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
            ])
            ->first();

        return ApiFormatter::getResponse($data);
    }

    public function datatables()
    {
        $data = TrxAccountingMaster::with('transaksitype', 'mapping')->where('fc_status', 'F')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function get($fc_trxno)
    {
        $trxno = base64_decode($fc_trxno);

        $data = TrxAccountingMaster::with('transaksitype', 'mapping')
            ->where([
                'fc_trxno' =>  $trxno,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
            ])
            ->first();

        return ApiFormatter::getResponse($data);
    }

    public function data($fc_trxno)
    {
        $decode_fc_trxno = base64_decode($fc_trxno);
        $data = TrxAccountingDetail::with('coamst', 'payment')->where('fc_trxno', $decode_fc_trxno)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function data_debit($fc_trxno)
    {
        $decode_fc_trxno = base64_decode($fc_trxno);
        $data = TrxAccountingDetail::with('coamst', 'payment')->where('fc_statuspos', 'D')->where('fc_trxno', $decode_fc_trxno)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function data_kredit($fc_trxno)
    {
        $decode_fc_trxno = base64_decode($fc_trxno);
        $data = TrxAccountingDetail::with('coamst', 'payment')->where('fc_statuspos', 'C')->where('fc_trxno', $decode_fc_trxno)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function data_opsi($fc_trxno)
    {
        $decode_fc_trxno = base64_decode($fc_trxno);
        $data = SuppTrxAcc::with('coamst', 'payment')->where('fc_trxno', $decode_fc_trxno)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    // OPSI LANJUTAN
    public function datatables_opsi()
    {
        $data = TempSuppTrxAcc::with('coamst', 'payment')
            ->where('fc_trxno', auth()->user()->fc_userid)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    // EDIT OPSI LANJUTAN
    public function datatables_edit_opsi($fc_trxno)
    {
        $decode_fc_trxno = base64_decode($fc_trxno);
        $data = SuppTrxAcc::with('coamst', 'payment')
            ->where('fc_trxno', $decode_fc_trxno)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    // Store Opsi Biasa
    public function store_opsi(Request $request)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'fc_coacode' => 'required',
                'fc_paymentmethod' => 'required',
            ]);

            if ($validator->fails()) {
                return [
                    'status' => 300,
                    'message' => $validator->errors()->first()
                ];
            }

            $temp_detail = TempSuppTrxAcc::where('fc_trxno', auth()->user()->fc_userid)->orderBy('fn_rownum', 'DESC')->first();
            $fn_rownum = 1;
            if (!empty($temp_detail)) {
                $fn_rownum = $temp_detail->fn_rownum + 1;
            }


            $insert_debit = TempSuppTrxAcc::create([
                'fc_branch' => auth()->user()->fc_branch,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_trxno' => auth()->user()->fc_userid,
                'fn_rownum' => $fn_rownum,
                'fc_coacode' => $request->fc_coacode,
                'fc_statuspos' => 'O',
                'fc_paymentmethod' => $request->fc_paymentmethod,
                'fc_refno' => ($request->fc_refno === '') ? NULL : $request->fc_refno,
                'fd_agingref' => ($request->fd_agingref === '') ? NULL : $request->fd_agingref,
                'created_by' => auth()->user()->fc_userid
            ]);

            if ($insert_debit) {
                DB::commit();
                return [
                    'status' => 200,
                    'message' => 'Data berhasil disimpan'
                ];
            } else {
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

        // Store Edit Opsi
        public function store_edit_opsi(Request $request, $fc_trxno)
        {
            DB::beginTransaction();

            $decode_fc_trxno = base64_decode($fc_trxno);
            try {
                $validator = Validator::make($request->all(), [
                    'fc_coacode' => 'required',
                    'fc_paymentmethod' => 'required',
                ]);
    
                if ($validator->fails()) {
                    return [
                        'status' => 300,
                        'message' => $validator->errors()->first()
                    ];
                }
    
                $detail = SuppTrxAcc::where('fc_trxno', $decode_fc_trxno)->orderBy('fn_rownum', 'DESC')->first();
                $fn_rownum = 1;
                if (!empty($detail)) {
                    $fn_rownum = $detail->fn_rownum + 1;
                }
    
    
                $insert = SuppTrxAcc::create([
                    'fc_branch' => auth()->user()->fc_branch,
                    'fc_divisioncode' => auth()->user()->fc_divisioncode,
                    'fc_trxno' => $decode_fc_trxno,
                    'fn_rownum' => $fn_rownum,
                    'fc_coacode' => $request->fc_coacode,
                    'fc_statuspos' => 'O',
                    'fc_paymentmethod' => $request->fc_paymentmethod,
                    'fc_refno' => ($request->fc_refno === '') ? NULL : $request->fc_refno,
                    'fd_agingref' => ($request->fd_agingref === '') ? NULL : $request->fd_agingref,
                    'created_by' => auth()->user()->fc_userid
                ]);
    
                if ($insert) {
                    DB::commit();
                    return [
                        'status' => 200,
                        'message' => 'Data berhasil disimpan'
                    ];
                } else {
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

    public function update_opsi(Request $request)
    {
        // validator
        $validator = Validator::make($request->all(), [
            'fn_rownum' => 'required',
            'fc_mappingcode' => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        DB::beginTransaction();

        try {
            $updateDescription = true;
            $updateNominal = true;

            $updateData = [
                'updated_by' => auth()->user()->fc_userid
            ];

            if ($updateNominal && strpos($request->fm_nominal, 'Rp') === false) {
                $updateData['fm_nominal'] = Convert::convert_to_double($request->fm_nominal);
            }

            if ($updateDescription) {
                $updateData['fv_description'] = $request->fv_description;
            }

            $updateNominal = TempSuppTrxAcc::where('fc_trxno', auth()->user()->fc_userid)
                ->where('fn_rownum', $request->fn_rownum)
                ->update($updateData);

            if ($updateNominal) {
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
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function update_edit_opsi(Request $request, $fc_trxno)
    {
        $decode_fc_trxno = base64_decode($fc_trxno);
        // validator
        $validator = Validator::make($request->all(), [
            'fn_rownum' => 'required',
            'fc_mappingcode' => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        DB::beginTransaction();

        try {
            $updateDescription = true;
            $updateNominal = true;

            $updateData = [
                'updated_by' => auth()->user()->fc_userid
            ];

            if ($updateNominal && strpos($request->fm_nominal, 'Rp') === false) {
                $updateData['fm_nominal'] = Convert::convert_to_double($request->fm_nominal);
            }

            if ($updateDescription) {
                $updateData['fv_description'] = $request->fv_description;
            }

            $updateNominal = SuppTrxAcc::where('fc_trxno', $decode_fc_trxno)
                ->where('fn_rownum', $request->fn_rownum)
                ->update($updateData);

            if ($updateNominal) {
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
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function update_status_opsi_lanjutan(Request $request)
    {
        $update = TempTrxAccountingMaster::where('fc_trxno', auth()->user()->fc_userid)
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->update([
                        'fv_description' => $request->fv_description_submit,
                        'fc_status' => 'I-2'
                    ]);

        if ($update) {
            return [
                'status' => 201,
                'message' => 'Data berhasil diubah',
                'link' => '/apps/transaksi/opsi-lanjutan'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Data gagal diubah'
            ];
        }
    }

    // buat edit
    public function update_edit_status_opsi_lanjutan($fc_trxno)
    {
        $decode_fc_trxno = base64_decode($fc_trxno);
        $update = TrxAccountingMaster::where('fc_trxno', $decode_fc_trxno)
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->update([
                        'fc_status' => 'U-2'
                    ]);

        if ($update) {
            return [
                'status' => 201,
                'message' => 'Data berhasil diubah',
                'link' => '/apps/transaksi/edit-opsi/' . $fc_trxno
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Data gagal diubah'
            ];
        }
    }

    // DELETE DI OPSI LANJUTAN 
    public function delete_opsi($fc_trxno, $fn_rownum)
    {
        $deleteOpsi = TempSuppTrxAcc::where([
            'fc_trxno' => $fc_trxno,
            'fn_rownum' => $fn_rownum,
        ])->delete();

        if ($deleteOpsi) {
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

    // DELETE DI EDIT OPSI LANJUTAN
    public function edit_delete_opsi($fc_trxno, $fn_rownum)
    {
        $decode_fc_trxno = base64_decode($fc_trxno);
        $deleteOpsi = SuppTrxAcc::where([
            'fc_trxno' => $decode_fc_trxno,
            'fn_rownum' => $fn_rownum,
        ])->delete();

        if ($deleteOpsi) {
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

    public function datatables_bookmark()
    {
        $data = TempTrxAccountingMaster::with('transaksitype', 'mapping')
            ->where('fc_status', 'P')
            ->where('fc_userid', auth()->user()->fc_userid)
            ->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function datatables_bookmark_all()
    {
        $data = TempTrxAccountingMaster::with('transaksitype', 'mapping')
            ->where('fc_status', 'P')
            ->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function datatables_giro($fc_giropos)
    {
        $data = Giro::with('transaksi.mapping', 'coa')->where('fc_giropos', $fc_giropos)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->orderBy('fc_girostatus', 'DESC')
            ->orderBy('fd_agingref', 'ASC')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function datatables_mapping()
    {
        $data = MappingUser::with('mappingmst.tipe', 'mappingmst.transaksi', 'user')->where('fc_userid', auth()->user()->fc_userid)->where('fc_hold', 'F')->where('fc_branch', auth()->user()->fc_branch)->get();


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

    public function datatables_invoice()
    {
        $data = InvoiceMst::with('domst', 'pomst', 'somst', 'romst', 'supplier', 'customer')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function store_update(Request $request)
    {
        // validator
        $validator = Validator::make($request->all(), [
            'fc_mappingcode' => 'required',
            'fc_docreference' => 'required',
        ], [
            'fc_docreference.required' => 'Referensi wajib diisi',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $temp_trxaccounting_mst = TempTrxAccountingMaster::where('fc_trxno', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->first();

        if (empty($temp_trxaccounting_mst)) {
            $insert = TempTrxAccountingMaster::create([
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_trxno' => auth()->user()->fc_userid,
                'fc_mappingcode' => $request->fc_mappingcode,
                'fc_mappingtrxtype' => $request->fc_mappingtrxtype_hidden,
                'fc_docreference' => $request->fc_docreference !== null ? $request->fc_docreference : "",
                'fc_status' => 'I',
                'fd_trxdate_byuser' => date('Y-m-d H:i:s', strtotime($request->fd_trxdate_byuser)),
                'fc_userid' => auth()->user()->fc_userid,
            ]);

            if ($insert) {
                return [
                    'status' => 201,
                    'message' => 'Data berhasil disimpan',
                    'link' => '/apps/transaksi/create-index'
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

    public function request_approval(Request $request)
    {
        // validator
        $validator = Validator::make($request->all(), [
            'fc_annotation' => 'required',
        ], [
            'fc_annotation.required' => 'Keterangan wajib diisi',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $insert = Approvement::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_applicantid' => auth()->user()->fc_userid,
            'fc_annotation' => $request->fc_annotation,
            'fc_trxno' => $request->fc_trxno,
            'fc_approvalstatus' => 'W',
            'fd_userinput' => Carbon::now(),
        ]);

        if ($insert) {
            return [
                'status' => 201,
                'message' => 'Request berhasil dikirim',
                'link' => '/apps/transaksi'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Request gagal dikirim'
            ];
        }
    }

    public function lanjutkan_bookmark($fc_trxno)
    {
        //decode
        $trxno = base64_decode($fc_trxno);
        $exist_data = TempTrxAccountingMaster::where('fc_trxno', auth()->user()->fc_userid)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->count();

        if ($exist_data > 0) {
            return [
                'status' => 300,
                'message' => 'Terdapat input transaksi yang belum selesai'
            ];
        }

        $update = TempTrxAccountingMaster::where('fc_trxno', $trxno)->update([
            'fc_status' => 'I',
            'fc_trxno' => auth()->user()->fc_userid,
        ]);

        if ($update) {
            // return response
            return [
                'status' => 201,
                'message' => 'success',
                'link' => '/apps/transaksi/create-index'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'failed'
            ];
        }
    }

    public function pending(Request $request)
    {
        $data = TempTrxAccountingMaster::where('fc_trxno', auth()->user()->fc_userid)->update([
            'fc_status' => 'P',
            'fv_description' => $request->fv_description
        ]);

        if ($data) {
            return [
                'status' => 200,
                'message' => 'Data berhasil di Pending',
                'link' => '/apps/transaksi'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Data gagal di Pending'
            ];
        }
    }

    public function clear(Request $request)
    {
        $id = $request->id;
        $fc_girostatus = $request->fc_girostatus;
        $data = Giro::where('id', $id)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $data->update([
            'fc_girostatus' => $fc_girostatus,
        ]);


        if ($update_status) {
            return [
                'status' => 200,
                'message' => 'Data berhasil dituntaskan',
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data gagal dituntaskan'
        ];
    }

    public function cancel_transaksi()
    {
        DB::beginTransaction();

        try {
            TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->delete();
            TempTrxAccountingMaster::where('fc_trxno', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->delete();

            DB::commit();

            return [
                'status' => 201, // SUCCESS
                'link' => '/apps/transaksi',
                'message' => 'Data berhasil dicancel'
            ];
        } catch (\Exception $e) {

            DB::rollback();

            return [
                'status'     => 300, // GAGAL
                'message'       => (env('APP_DEBUG', 'true') == 'true') ? $e->getMessage() : 'Operation error'
            ];
        }
    }

    public function cek_exist_approval($fc_trxno)
    {
        // decode fc_trxno
        $decode_fc_trxno = base64_decode($fc_trxno);
        $cek_step1 = Approvement::where('fc_trxno', $decode_fc_trxno)
            ->where('fc_approvalused', 'F')
            ->where('fc_branch', auth()->user()->fc_branch)
            ->exists();

        // dd($cek);
        if ($cek_step1) {
            return [
                'status' => 200,
                'approve' => 'wait',
                'message' => 'Transaksi ini sedang dalam proses Approvement',
            ];
        } else {
            return [
                'status' => 200,
                'approve' => 'request',
            ];
        }
    }
}
