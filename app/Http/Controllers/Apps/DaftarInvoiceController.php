<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use PDF;
use App\Models\RoDetail;
use App\Models\DoDetail;
use App\Models\InvoiceDtl;
use App\Models\InvoiceMst;
use App\Helpers\ApiFormatter;
use App\Models\Approval;
use App\Models\DoMaster;
use App\Models\TransaksiType;
use App\Models\User;
use Validator;
use Carbon\Carbon;

class DaftarInvoiceController extends Controller
{
    public function index()
    {
        return view('apps.daftar-invoice.index');
    }

    public function detail($fc_invno, $fc_invtype)
    {
        set_time_limit(360);
        $decode_fc_invno = base64_decode($fc_invno);
        session(['fc_invno_global' => $decode_fc_invno]);
        $inv_master = InvoiceMst::with('customer')->where('fc_invno', $decode_fc_invno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $decoded_childsuppdocno_array = json_decode($inv_master->fc_child_suppdocno, true);
        
        if ($fc_invtype == "SALES") {
            $data['inv_mst'] = InvoiceMst::with('domst', 'somst', 'customer')->where('fc_invno', $decode_fc_invno)->where('fc_invtype', 'SALES')->where('fc_branch', auth()->user()->fc_branch)->first();
            $data['inv_dtl'] = InvoiceDtl::with('invmst', 'nameunity')->where('fc_invno', $decode_fc_invno)->where('fc_invtype', 'SALES')->where('fc_branch', auth()->user()->fc_branch)->get();
            $decoded_childsuppdocno_array = [$inv_master->fc_child_suppdocno];
            if(count($decoded_childsuppdocno_array) > 0){   
                $data['do_mst'] = DoMaster::with('somst.customer')
                ->where(function ($query) use ($decoded_childsuppdocno_array) {
                    foreach ($decoded_childsuppdocno_array as $index => $value) {
                        if ($index === 0) {
                            $query->where('fc_dono', $value);
                        } else {
                            $query->orWhere('fc_dono', $value);
                        }
                    }
                })
                ->where('fc_branch', auth()->user()->fc_branch)
                ->get();
            }
        } else if ($fc_invtype == "PURCHASE") {
            $data['inv_mst'] = InvoiceMst::with('pomst', 'romst', 'supplier')->where('fc_invno', $decode_fc_invno)->where('fc_invtype', 'PURCHASE')->where('fc_branch', auth()->user()->fc_branch)->first();
            $data['inv_dtl'] = InvoiceDtl::with('invmst', 'nameunity')->where('fc_invno', $decode_fc_invno)->where('fc_invtype', 'PURCHASE')->where('fc_branch', auth()->user()->fc_branch)->get();
            if(count($decoded_childsuppdocno_array) > 0){   
                $data['do_mst'] = DoMaster::with('somst.customer')
                ->where(function ($query) use ($decoded_childsuppdocno_array) {
                    foreach ($decoded_childsuppdocno_array as $index => $value) {
                        if ($index === 0) {
                            $query->where('fc_dono', $value);
                        } else {
                            $query->orWhere('fc_dono', $value);
                        }
                    }
                })
                ->where('fc_branch', auth()->user()->fc_branch)
                ->get();
            }
        } else {
            $data['inv_mst'] = InvoiceMst::with('domst', 'somst', 'customer')->where('fc_invno', $decode_fc_invno)->where('fc_invtype', 'CPRR')->where('fc_branch', auth()->user()->fc_branch)->first();
            $data['inv_dtl'] = InvoiceDtl::with('invmst', 'nameunity', 'cospertes')->where('fc_invno', $decode_fc_invno)->where('fc_invtype', 'CPRR')->where('fc_branch', auth()->user()->fc_branch)->get();
            // if(count($decoded_childsuppdocno_array) > 0){   
            $data['do_mst'] = DoMaster::with('somst.customer')
                // ->where(function ($query) use ($decoded_childsuppdocno_array) {
                //     foreach ($decoded_childsuppdocno_array as $index => $value) {
                //         if ($index === 0) {
                //             $query->where('fc_dono', $value);
                //         } else {
                //             $query->orWhere('fc_dono', $value);
                //         }
                //     }
                // })
                ->where('fc_branch', auth()->user()->fc_branch)
                ->get();
            // }
        }
        $data['fc_invno'] = $decode_fc_invno;
        return view('apps.daftar-invoice.detail', $data);
        // dd($data);
    }

    public function datatables($fc_invtype)
    {

        $data = InvoiceMst::with('domst', 'pomst', 'somst', 'romst', 'supplier', 'customer')->where('fc_branch', auth()->user()->fc_branch)->where('fc_invtype', $fc_invtype)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_inv_detail($fc_invno)
    {
        $decode_fc_invno = base64_decode($fc_invno);
        $data = InvoiceDtl::with('invmst', 'cospertes', 'nameunity')
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_invno', $decode_fc_invno)
            ->where('fc_status', 'ADDON')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_do_detail($fc_invno)
    {
        $decode_fc_invno = base64_decode($fc_invno);
        $data = InvoiceDtl::with('invstore.stock', 'invmst')
            ->where('fc_invno', $decode_fc_invno)
            ->where('fc_status', 'DEFAULT')
            ->where('fc_invtype', "SALES")
            ->where('fc_branch', auth()->user()->fc_branch)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($fc_dono);
    }

    public function datatables_ro_detail($fc_invno)
    {
        $decode_fc_invno = base64_decode($fc_invno);
        $data = InvoiceDtl::with('invstore.stock', 'invmst')
            ->where('fc_invno', $decode_fc_invno)
            ->where('fc_status', 'DEFAULT')
            ->where('fc_invtype', "PURCHASE")
            ->where('fc_branch', auth()->user()->fc_branch)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_cprr($fc_invno)
    {
        $decode_fc_invno = base64_decode($fc_invno);
        $data = InvoiceDtl::with('invstore.stock', 'invmst', 'nameunity', 'cospertes')
            ->where('fc_invno', $decode_fc_invno)
            ->where('fc_status', 'DEFAULT')
            ->where('fc_invtype', "CPRR")
            ->where('fc_branch', auth()->user()->fc_branch)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function pdf(Request $request)
    {
        // dd($request);
        set_time_limit(360);
        $encode_fc_invno = base64_encode($request->fc_invno);
        $data['inv_mst'] = InvoiceMst::with('domst', 'pomst', 'somst', 'romst', 'supplier', 'customer', 'bank')->where('fc_invno', $request->fc_invno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['inv_dtl'] = InvoiceDtl::with('invmst', 'nameunity', 'cospertes')->where('fc_invno', $request->fc_invno)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['tampil_diskon'] = $request->tampil_diskon;

        if ($request->name_pj === auth()->user()->fc_username) {
            $data['nama_pj'] = $request->name_pj;

            InvoiceMst::where('fc_invno', $request->fc_invno)
                ->where('fc_branch', auth()->user()->fc_branch)
                ->increment('fn_printout', 1);

            $insert = Approval::create([
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_applicantid' => $request->name_pj,
                'fc_accessorid' => $request->name_pj,
                'fc_approvalstatus' => 'A',
                'fc_annotation' => 'No Need Approval',
                'fd_accessorrespon' => 'No Need Approval',
                'fc_docno' => $request->fc_invno,
                'fd_userinput' => Carbon::now(),
            ]);

            if ($insert) {
                return [
                    'status' => 201,
                    'message' => 'Invoice Berhasil ditampilkan',
                    'link' => '/apps/daftar-invoice/get_pdf/' . $encode_fc_invno . '/' . $data['nama_pj'] . '/' . $data['tampil_diskon'],
                ];
            } else {
                $data['fc_invno'] = $request->fc_invno;
                $data['name_pj'] = $request->name_pj;

                return [
                    'status' => 300,
                    'message' => 'Invoice Gagal ditampilkan'
                ];
            }
        } else {
            return [
                'status' => 301,
            ];
        }
    }

    public function get_pdf($fc_invno, $nama_pj, $tampil_diskon)
    {
        set_time_limit(360);
        $decode_fc_invno = base64_decode($fc_invno);
        $data['inv_mst'] = InvoiceMst::with('domst', 'pomst', 'somst', 'romst', 'supplier', 'customer')->where('fc_invno', $decode_fc_invno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['inv_dtl'] = InvoiceDtl::with('invstore.stock', 'invmst', 'nameunity', 'cospertes')->where('fc_invno', $decode_fc_invno)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['nama_pj'] = $nama_pj;
        $data['tampil_diskon'] = $tampil_diskon;
        $data['user'] = User::where('fc_userid', $nama_pj)->where('fc_branch', auth()->user()->fc_branch)->first();
        $pdf = PDF::loadView('pdf.invoice', $data)->setPaper('a4');
        return $pdf->stream();
    }

    public function kwitansi(Request $request)
    {
        // dd($request);
        $encode_fc_invno = base64_encode($request->fc_invno);
        $data['inv_mst'] = InvoiceMst::with('domst', 'pomst', 'somst', 'romst', 'supplier', 'customer', 'bank')->where('fc_invno', $request->fc_invno)->where('fc_branch', auth()->user()->fc_branch)->first();
        if ($request->name_pj) {
            $data['nama_pj'] = $request->name_pj;
        } else {
            $data['nama_pj'] = auth()->user()->fc_username;
        }

        return [
            'status' => 201,
            'message' => 'Kwitansi Berhasil ditampilkan',
            'link' => '/apps/daftar-invoice/get_kwitansi/' . $encode_fc_invno . '/' . $data['nama_pj'],
        ];
    }

    public function get_kwitansi($fc_invno, $nama_pj)
    {
        $decode_fc_invno = base64_decode($fc_invno);
        $data['inv_mst'] = InvoiceMst::with('domst', 'pomst', 'somst', 'romst', 'supplier', 'customer')->where('fc_invno', $decode_fc_invno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['nama_pj'] = $nama_pj;
        $pdf = PDF::loadView('pdf.kwitansi', $data)->setPaper('a4');
        return $pdf->stream();
    }

    public function get_user()
    {
        $data = User::where('fl_level', '3')
            ->get();

        return ApiFormatter::getResponse($data);
    }

    public function get($fc_invno)
    {
        $invno = base64_decode($fc_invno);

        $data = InvoiceMst::where([
            'fc_invno' =>  $invno,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
        ])
            ->first();

        return ApiFormatter::getResponse($data);
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

        if (Approval::where('fc_docno', $request->fc_invno)
            ->where('fc_approvalstatus', 'W')
            ->exists()
        ) {
            return [
                'status' => 300,
                'message' => 'Approval yang sama sedang diajukan oleh user lain'
            ];
        } else {
            $insert = Approval::create([
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_applicantid' => auth()->user()->fc_userid,
                'fc_accessorid' => $request->name_pj,
                'fc_annotation' => $request->fc_annotation,
                'fc_docno' => $request->fc_invno,
                'fd_userinput' => Carbon::now(),
            ]);

            if ($insert) {
                return [
                    'status' => 201,
                    'message' => 'Request berhasil dikirim',
                    'link' => '/apps/daftar-invoice'
                ];
            } else {
                return [
                    'status' => 300,
                    'message' => 'Request gagal dikirim'
                ];
            }
        }
    }

    public function cek_exist_approval($fc_invno)
    {
        // decode fc_invno
        $decode_fc_invno = base64_decode($fc_invno);
        $cek_step1 = Approval::where('fc_docno', $decode_fc_invno)->where('fc_branch', auth()->user()->fc_branch)->exists();

        // dd($cek);
        if ($cek_step1) {
            $cek_step2 = Approval::where('fc_docno', $decode_fc_invno)
                ->where('fc_approvalstatus', 'A')->where('fc_branch', auth()->user()->fc_branch)
                ->exists();
            $accesor =  Approval::where('fc_docno', $decode_fc_invno)
                ->where('fc_approvalstatus', 'A')->where('fc_branch', auth()->user()->fc_branch)->first();

            if ($cek_step2) {
                $get_accesor = $accesor->fc_accessorid;

                InvoiceMst::where('fc_invno', $decode_fc_invno)
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->increment('fn_printout', 1);

                return [
                    'status' => 200,
                    'approve' => 'pdf',
                    'message' => 'Approval berhasil dikirim',
                    'link' => '/apps/daftar-invoice/get_pdf/' . $fc_invno . '/' . $get_accesor,
                ];
            } else {
                return [
                    'status' => 200,
                    'approve' => 'wait',
                    'message' => 'Mohon ditunggu Invoice sedang proses Approvement',
                ];
            }
        } else {
            return [
                'status' => 200,
                'approve' => 'request',
                'message' => 'Pilih Penandatangan !!',
            ];
        }
    }

    public function edit_description(Request $request)
    {
        $decode_invno = base64_encode($request->fc_invno);
        InvoiceMst::where('fc_invno', $request->fc_invno)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->where('fc_invtype', $request->fc_invtype)
        ->update([
            'fv_description' => $request->fv_description,
        ]);

        return [
            'status' => 201, // SUCCESS
            'link' => '/apps/daftar-invoice/detail/' . $decode_invno . '/' . $request->fc_invtype,
            'message' => 'Catatan berhasil diubah'
        ];
        // dd($request);
    }
}
