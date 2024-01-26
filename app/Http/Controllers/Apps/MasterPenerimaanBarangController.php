<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use DB;
use PDF;

use App\Models\GoodReception;
use Yajra\DataTables\DataTables as DataTables;

class MasterPenerimaanBarangController extends Controller
{

    public function index()
    {
        return view('apps.master-penerimaan-barang.index');
    }

    public function datatables(){
        $data = GoodReception::with('supplier')->where('fc_branch', auth()->user()->fc_branch)->where('fc_status', 'R')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }
    
    public function datatables_master_transit(){
        $data = GoodReception::with('supplier')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function pdf(Request $request){
        // dd($request);
        $encode_fc_grno = base64_encode($request->fc_grno);
        $data['gr_mst']= GoodReception::where('fc_grno', $request->fc_grno)->where('fc_branch', auth()->user()->fc_branch)->first();
        if($request->name_pj){
            $data['nama_pj'] = $request->name_pj;
        }else{
            $data['nama_pj'] = auth()->user()->fc_username;
        }

        //redirect ke /apps/master-receiving-order/pdf dengan mengirimkan $data
        return [
            'status' => 201,
            'message' => 'PDF Berhasil ditampilkan',
            'link' => '/apps/master-penerimaan-barang/get_pdf/' . $encode_fc_grno . '/' . $data['nama_pj'],
        ];
        // dd($request);
    }

    public function doc($fc_grno, $count){
        $decode_fc_grno = base64_decode($fc_grno);
        $count_decode = base64_decode($count);

        $data['gr_mst']= GoodReception::with('supplier')->where('fc_grno', $decode_fc_grno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $pdf = PDF::loadView('pdf.doc-penerimaan-barang', 
            [
                'fc_grno' => $decode_fc_grno,
                'count' => $count_decode
            ]
            , $data)->setPaper('C7','portrait');
    
        return $pdf->stream();
    }

    public function get_pdf($fc_grno,$nama_pj){
        $decode_fc_grno = base64_decode($fc_grno);
        $data['gr_mst']= GoodReception::with('supplier')->where('fc_grno', $decode_fc_grno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['gr_dtl']= GoodReception::where('fc_grno', $decode_fc_grno)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['nama_pj'] = $nama_pj;
        $pdf = PDF::loadView('pdf.penerimaan-barang', $data)->setPaper('a4');
        return $pdf->stream();
    }

    public function clear(Request $request){
        // dd($request);
        $fc_grno = $request->fc_grno;
        $fc_status = $request->fc_status;
        $data = GoodReception::where('fc_grno', $fc_grno)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $data->update([
            'fc_status' => $fc_status,
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
}
