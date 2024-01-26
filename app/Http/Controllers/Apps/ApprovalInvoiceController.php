<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiFormatter;
use Carbon\Carbon;
use Yajra\DataTables\DataTables as DataTables;
use File;
use PDF;
use DB;

use App\Models\Approval;
use App\Models\InvoiceMst;
use App\Models\InvoiceDtl;
use App\Models\User;

class ApprovalInvoiceController extends Controller
{

    public function index(){
        return view('apps.approval-invoice.index');
    }

    public function datatables_accessor(){
        $data = Approval::with('branch')->where('fc_accessorid', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function datatables_applicant(){
        $data = Approval::with('branch')
        ->where('fc_applicantid', auth()->user()->fc_userid)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function cancel(Request $request){
        $fc_approvalno = $request->fc_approvalno_cancel;
        $fv_description = $request->fv_description;

        // update
        $data = Approval::where('fc_approvalno', $fc_approvalno)->where('fc_branch', auth()->user()->fc_branch)->first();

        $insert = $data->update([
            'fc_approvalstatus' => 'C',
            'fv_description' => $fv_description,
        ]);

        if ($insert) {
            return [
                'status' => 201,
                'message' => 'Approval berhasil dicancel',
                'link' => '/apps/approval-invoice'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Approval gagal dicancel'
        ];
    }

    public function reject(Request $request){
        $fc_approvalno = $request->fc_approvalno_reject;
        $fd_accessorrespon = $request->fd_accessorrespon_reject;
        $fd_approvaldate = Carbon::now();

        // update
        $data = Approval::where('fc_approvalno', $fc_approvalno)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $data->update([
            'fc_approvalstatus' => 'R',
            'fd_accessorrespon' => $fd_accessorrespon,
            'fd_approvaldate' => $fd_approvaldate,
        ]);

        if ($update_status) {
            return [
                'status' => 201,
                'message' => 'Approval berhasil direject',
                'link' => '/apps/approval-invoice'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Approval gagal direject'
        ];
    }

    public function accept(Request $request){
        $fc_approvalno = $request->fc_approvalno_accept;
        $fd_accessorrespon = $request->fd_accessorrespon_accept;
        $fd_approvaldate = Carbon::now();

        // update
        $data = Approval::where('fc_approvalno', $fc_approvalno)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $data->update([
            'fc_approvalstatus' => 'A',
            'fd_accessorrespon' => $fd_accessorrespon,
            'fd_approvaldate' => $fd_approvaldate,
        ]);

        if ($update_status) {
            return [
                'status' => 201,
                'message' => 'Approval berhasil diaccept',
                'link' => '/apps/approval-invoice'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Approval gagal diaccept'
        ];
    }

    public function get($fc_approvalno)
    {
        $approvalno = base64_decode($fc_approvalno);

        $data = Approval::with('branch')
            ->where([
                'fc_approvalno' =>  $approvalno,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
            ])
            ->first();

        return ApiFormatter::getResponse($data);
    }

    public function get_data($fc_approvalno)
    {
        $approvalno = base64_decode($fc_approvalno);

        $data = Approval::with('branch')
            ->where([
                'fc_approvalno' =>  $approvalno,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
            ])
            ->first();

        return ApiFormatter::getResponse($data);
    }

    public function pdf(Request $request)
    {
        // dd($request);
        $encode_fc_docno = base64_encode($request->fc_docno);
        $data['inv_mst'] = InvoiceMst::with('domst', 'pomst', 'somst', 'romst', 'supplier', 'customer', 'bank')->where('fc_invno', $request->fc_docno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['inv_dtl'] = InvoiceDtl::with('invmst', 'nameunity', 'cospertes')->where('fc_invno', $request->fc_docno)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['nama_pj'] = $request->fc_accessorid;
    
        InvoiceMst::where('fc_invno', $request->fc_docno)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->increment('fn_printout', 1);

        return [
            'status' => 201,
            'message' => 'Invoice Berhasil ditampilkan',
            'link' => '/apps/approval-invoice/get_pdf/' . $encode_fc_docno . '/' . $data['nama_pj'],
        ];
    }

    public function get_pdf($fc_docno, $fc_accessorid)
    {
        $decode_fc_docno = base64_decode($fc_docno);
        $data['inv_mst'] = InvoiceMst::with('domst', 'pomst', 'somst', 'romst', 'supplier', 'customer')->where('fc_invno', $decode_fc_docno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['user'] = User::where('fc_userid', $fc_accessorid)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['inv_dtl'] = InvoiceDtl::with('invstore.stock', 'invmst', 'nameunity', 'cospertes')->where('fc_invno', $decode_fc_docno)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['nama_pj'] = $fc_accessorid;
        $pdf = PDF::loadView('pdf.invoice', $data)->setPaper('letter');
        return $pdf->stream();
    }
}
