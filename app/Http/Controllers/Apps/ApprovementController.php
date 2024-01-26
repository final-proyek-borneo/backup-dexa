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
use DB;

use App\Models\Approvement;
use App\Models\TrxAccountingMaster;
use App\Models\TrxAccountingDetail;

class ApprovementController extends Controller
{

    public function index(){
        return view('apps.approvement.index');
    }

    public function datatables(){
        $data = Approvement::with('branch')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function datatables_applicant(){
        $data = Approvement::with('branch')
        ->where('fc_applicantid', auth()->user()->fc_userid)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function get($fc_approvalno)
    {
        $approvalno = base64_decode($fc_approvalno);

        $data = Approvement::with('branch')
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

        $data = Approvement::with('branch')
            ->where([
                'fc_approvalno' =>  $approvalno,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
            ])
            ->first();

        return ApiFormatter::getResponse($data);
    }

    public function cancel(Request $request){
        $fc_approvalno = $request->fc_approvalno_cancel;
        $fv_description = $request->fv_description;

        // update
        $data = Approvement::where('fc_approvalno', $fc_approvalno)->where('fc_branch', auth()->user()->fc_branch)->first();

        $insert = $data->update([
            'fc_approvalstatus' => 'C',
            'fv_description' => $fv_description,
        ]);

        if ($insert) {
            return [
                'status' => 201,
                'message' => 'Approval berhasil dicancel',
                'link' => '/apps/approvement'
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
        $fc_accessorid = auth()->user()->fc_userid;
        $fd_approvaldate = Carbon::now();

        // update
        $data = Approvement::where('fc_approvalno', $fc_approvalno)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $data->update([
            'fc_approvalstatus' => 'R',
            'fc_accessorid' => $fc_accessorid,
            'fd_accessorrespon' => $fd_accessorrespon,
            'fd_approvaldate' => $fd_approvaldate,
        ]);

        if ($update_status) {
            return [
                'status' => 201,
                'message' => 'Approval berhasil direject',
                'link' => '/apps/approvement'
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
        $fc_accessorid = auth()->user()->fc_userid;
        $fd_approvaldate = Carbon::now();

        // update
        $data = Approvement::where('fc_approvalno', $fc_approvalno)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $data->update([
            'fc_approvalstatus' => 'A',
            'fc_accessorid' => $fc_accessorid,
            'fd_accessorrespon' => $fd_accessorrespon,
            'fd_approvaldate' => $fd_approvaldate,
        ]);

        if ($update_status) {
            return [
                'status' => 201,
                'message' => 'Approval berhasil diaccept',
                'link' => '/apps/approvement'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Approval gagal diaccept'
        ];
    }

    public function edit($fc_trxno){
        //decode
        $trxno = base64_decode($fc_trxno);
        $encode_trxno = base64_encode($trxno);
        $exist_data = TrxAccountingMaster::where('fc_trxno', $fc_trxno)
        ->where('fc_status', 'U')
        ->first();

        if($exist_data > 0){
            return [
                'status' => 300,
                'message' => 'Maaf Transaksi sedang Diperbaiki'
            ];
        }

        $update = TrxAccountingMaster::where('fc_trxno', $trxno)->update([
            'fc_status' => 'U',
        ]);
        
        if ($update) {
            // return response
            return[
                'status' => 201,
                'message' =>'success',
                'link' => '/apps/transaksi/edit/' . $encode_trxno
            ];
        } else {
            return[
                'status' => 300,
                'message' =>'failed'
            ];
        }

    }
}
