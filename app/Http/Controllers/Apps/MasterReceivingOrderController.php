<?php

namespace App\Http\Controllers\Apps;

use App\Exports\ReceivingOrderExport;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;

use PDF;
use Carbon\Carbon;
use File;
use DB;

use App\Models\RoMaster;
use App\Models\RoDetail;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\DataTables as DataTables;

class MasterReceivingOrderController extends Controller
{

    public function index()
    {
        return view('apps.master-receiving-order.index');
    }

    public function datatables()
    {
        ini_set('memory_limit', '2048M'); // 2GB
        $data = RoMaster::with('pomst.supplier', 'rodtl.invstore')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function detail($fc_rono)
    {
        $decode_fc_rono = base64_decode($fc_rono);
        session(['fc_rono_global' => $decode_fc_rono]);
        $data['ro_mst'] = RoMaster::with('pomst.supplier')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl'] = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->get();
        return view('apps.master-receiving-order.detail', $data);
        // dd($data);
    }

    public function datatables_ro_detail()
    {
        ini_set('memory_limit', '2048M');
        $data = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', session('fc_rono_global'))->where('fc_branch', auth()->user()->fc_branch)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function generateQRCodePDF($fc_barcode, $count, $fd_expired_date, $fc_batch)
    {

        $fc_barcode_decode = base64_decode($fc_barcode);
        $count_decode = base64_decode($count);

        $qrcode = QrCode::size(250)->generate($fc_barcode_decode);


        // generate qrcode ke pdf
        $customPaper = array(0, 0, 300, 300);        
        $pdf = PDF::loadView(
            'pdf.qr-code',
            [
                'qrcode' => $qrcode,
                'count' => $count_decode
            ]
        )->setPaper($customPaper);


        return $pdf->stream();
        // dd($kode_qr);
    }


    public function pdf(Request $request)
    {
        // dd($request);
        $decode_fc_rono = base64_encode($request->fc_rono);
        $data['ro_mst'] = RoMaster::with('pomst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl'] = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->get();
        if ($request->name_pj) {
            $data['nama_pj'] = $request->name_pj;
        } else {
            $data['nama_pj'] = auth()->user()->fc_username;
        }
        // $pdf = PDF::loadView('pdf.purchase-order', $data)->setPaper('a4');
        // return $pdf->stream();
        // dd($data);

        //redirect ke /apps/master-receiving-order/pdf dengan mengirimkan $data
        return [
            'status' => 201,
            'message' => 'PDF Berhasil ditampilkan',
            'link' => '/apps/master-receiving-order/get_pdf/' . $decode_fc_rono . '/' . $data['nama_pj'],
        ];
    }

    public function get_pdf($fc_rono, $nama_pj)
    {
        $decode_fc_rono = base64_decode($fc_rono);
        $data['ro_mst'] = RoMaster::with('pomst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl'] = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['nama_pj'] = $nama_pj;
        $pdf = PDF::loadView('pdf.receiving-order', $data)->setPaper('a4');
        return $pdf->stream();
    }

    public function export_excel($status){
        if($status == 'terbayar'){
            return Excel::download(new ReceivingOrderExport('P'), 'bpb_master_terbayar.xlsx');
        }else if($status == 'diterima'){
            return Excel::download(new ReceivingOrderExport('R'), 'bpb_master_diterima.xlsx');
        }else{
            return Excel::download(new ReceivingOrderExport('A'), 'bpb_master_all.xlsx');
        }
    }
}
