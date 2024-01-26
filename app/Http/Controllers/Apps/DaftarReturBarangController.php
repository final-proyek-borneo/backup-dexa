<?php

namespace App\Http\Controllers\Apps;

use App\Exports\ReturExport;
use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use PDF;
use App\Models\ReturMaster;
use App\Models\ReturDetail;
use App\Models\InvoiceDtl;
use App\Models\InvoiceMst;
use App\Models\TransaksiType;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class DaftarReturBarangController extends Controller
{
    public function index()
    {
        return view('apps.daftar-retur-barang.index');
    }

    public function detail($fc_returno)
    {
        $decode_fc_returno = base64_decode($fc_returno);
        session(['fc_returno_global' => $decode_fc_returno]);
        $data['retur_mst'] = ReturMaster::with('domst.somst')->where('fc_returno', $decode_fc_returno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['retur_dtl'] = ReturDetail::with('returmst', 'invstore')->where('fc_returno', $decode_fc_returno)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['fc_returno'] = $decode_fc_returno;
        return view('apps.daftar-retur-barang.detail', $data);
        // dd($data);
    }

    public function datatables()
    {

        $data = ReturMaster::with('domst')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_detail($fc_returno)
    {
        $decode_fc_returno = base64_decode($fc_returno);
        $data = ReturDetail::with('returmst', 'invstore.stock')->where('fc_returno', $decode_fc_returno)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function pdf(Request $request)
    {
        // dd($request);
        $encode_fc_returno = base64_encode($request->fc_returno);
        session(['fc_returno_global' => $encode_fc_returno]);
        $data['retur_mst'] = ReturMaster::with('domst.somst')->where('fc_returno', $request->fc_returno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['retur_dtl'] = ReturDetail::with('returmst', 'invstore')->where('fc_returno', $request->fc_returno)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['fc_returno'] = $encode_fc_returno;

        if ($request->name_pj) {
            $data['nama_pj'] = $request->name_pj;
        } else {
            $data['nama_pj'] = auth()->user()->fc_username;
        }

        return [
            'status' => 201,
            'message' => 'PDF Berhasil ditampilkan',
            'link' => '/apps/daftar-retur-barang/get_pdf/' . $encode_fc_returno . '/' . $data['nama_pj'],
        ];
    }

    public function get_pdf($fc_returno, $nama_pj)
    {
        $decode_fc_returno = base64_decode($fc_returno);
        $data['retur_mst'] = ReturMaster::with('domst.somst')->where('fc_returno', $decode_fc_returno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['retur_dtl'] = ReturDetail::with('returmst', 'invstore')->where('fc_returno', $decode_fc_returno)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['nama_pj'] = $nama_pj;
        $pdf = PDF::loadView('pdf.retur-barang', $data)->setPaper('a4');
        return $pdf->stream();
    }

    public function export_excel(){
      return Excel::download(new ReturExport, 'retur_master_all.xlsx');
    }
}
