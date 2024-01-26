<?php

namespace App\Http\Controllers\Apps;

use App\Exports\MutasiExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Convert;
use App\Models\MutasiMaster;
use App\Models\MutasiDetail;
use App\Models\User;
use Validator;
use PDF;

use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class DaftarMutasiBarangController extends Controller
{
    public function index()
    {
        return view('apps.daftar-mutasi-barang.index');
    }

    public function detail($fc_mutationno){
        ini_set('memory_limit', '2048M'); // 2GB
        set_time_limit(360);
        $encoded_fc_mutationno = base64_decode($fc_mutationno);
        session(['fc_mutationno_global' => $encoded_fc_mutationno]);
        $data['mutasi_mst'] = MutasiMaster::with('warehouse_start', 'warehouse_destination')->where('fc_mutationno', $encoded_fc_mutationno)->where('fc_branch', auth()->user()->fc_branch)->first();
        return view('apps.daftar-mutasi-barang.detail', $data);
        // dd($data);
    }
    
    public function datatables()
    {
        $data = MutasiDetail::with('invstore', 'stock')->where('fc_mutationno', session('fc_mutationno_global'))->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_internal()
    {
        $data = MutasiMaster::with('warehouse_start', 'warehouse_destination')->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_type_mutation', 'INTERNAL')
            ->get();
        // $data = MutasiDetail::with('stock')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_eksternal()
    {
        $data = MutasiMaster::with('warehouse_start', 'warehouse_destination')->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_type_mutation', 'EKSTERNAL')
            ->get();
        // $data = MutasiDetail::with('stock')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_belum_terlaksana()
    {
        $data = MutasiMaster::with('warehouse_start', 'warehouse_destination')->where('fc_branch', auth()->user()->fc_branch)->get();
        // $data = MutasiDetail::with('stock')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function pdf(Request $request){
        // dd($request);
        $encode_fc_mutationno = base64_encode($request->fc_mutationno);
        $data['mutasi_mst']= MutasiMaster::where('fc_mutationno', $request->fc_mutationno)->where('fc_branch', auth()->user()->fc_branch)->first();
        if($request->name_pj){
            $data['nama_pj'] = $request->name_pj;
        }else{
            $data['nama_pj'] = auth()->user()->fc_username;
        }

        //redirect ke /apps/daftar-mutasi-barang/pdf dengan mengirimkan $data
        return [
            'status' => 201,
            'message' => 'PDF Berhasil ditampilkan',
            'link' => '/apps/daftar-mutasi-barang/get_pdf/' . $encode_fc_mutationno . '/' . $data['nama_pj'],
        ];
        // dd($request);
    }

    public function get_pdf($fc_mutationno,$nama_pj){
        $decode_fc_mutationno = base64_decode($fc_mutationno);
        $data['mutasi_mst']= MutasiMaster::with('warehouse_start', 'warehouse_destination', 'somst')->where('fc_mutationno', $decode_fc_mutationno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['mutasi_dtl']= MutasiDetail::with('invstore', 'stock')->where('fc_mutationno', $decode_fc_mutationno)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['nama_pj'] = $nama_pj;
        $data['user'] = User::where('fc_userid', $nama_pj)->where('fc_branch', auth()->user()->fc_branch)->first();
        $pdf = PDF::loadView('pdf.mutasi-barang', $data)->setPaper('a4');
        return $pdf->stream();
        // dd($data);
    }

    public function submit(Request $request){
        $fc_mutationno = $request->fc_mutationno;
        $fc_penerima = $request->fc_penerima;

        DB::beginTransaction();
         
            try {
                $data = MutasiMaster::where('fc_mutationno', $fc_mutationno)->where('fc_branch', auth()->user()->fc_branch)->update([
                    'fc_statusmutasi' => 'F',
                    'fc_penerima' => $request->fc_penerima
                ]);
                // dd($request);
                
                DB::commit();
                if ($data) {
                    return [
                        'status' => 201, // SUCCESS
                        'link' => '/apps/daftar-mutasi-barang',
                        'message' => 'Mutasi Telah Terlaksana'
                    ];
                }
            } catch (\Exception $e) {

                DB::rollBack();

                return [
                    'status'     => 300, // GAGAL
                    'message'       => (env('APP_DEBUG', 'true') == 'true') ? $e->getMessage() : 'Operation error'
                ];
            }

            return [
                'status' => 300,
                'message' => 'Data gagal disimpan',
            ];
    }

    public function export_excel($status){
        if($status == 'internal'){
            return Excel::download(new MutasiExport('INTERNAL'), 'mutasi_master_internal.xlsx');
        }else if($status == 'eksternal'){
            return Excel::download(new MutasiExport('EKSTERNAL'), 'mutasi_master_eksternal.xlsx');
        }else{
            return Excel::download(new MutasiExport('BELUM'), 'mutasi_master_all.xlsx');
        }
    }
}
