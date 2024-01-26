<?php

namespace App\Http\Controllers\Apps;

use App\Exports\CprrExport;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;

use Yajra\DataTables\DataTables as DataTables;
use File;
use DB;

use App\Models\SoMaster;
use App\Models\SoDetail;
use App\Models\DoDetail;
use App\Models\TempSoPay;
use Maatwebsite\Excel\Facades\Excel;

class DaftarCprrController extends Controller
{

    public function index(){
        return view('apps.daftar-cprr.index');
    }

    public function detail($fc_sono){
        // kalau encode pakai base64_encode
        // kalau decode pakai base64_decode
        $encoded_fc_sono = base64_decode($fc_sono);
        session(['fc_sono_global' => $encoded_fc_sono]);
        $data['data'] = SoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', $encoded_fc_sono)->where('fc_branch', auth()->user()->fc_branch)->first();
        return view('apps.daftar-cprr.detail', $data);
        // dd($data);
    }

    public function datatables_so_payment(){
        $data = TempSoPay::where('fc_sono', session('fc_sono_global'))
        ->where('fc_branch', auth()->user()->fc_branch)
        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make();
    }

    public function datatables_so_detail()
    {
        $data = SoDetail::with('branch', 'warehouse', 'stock', 'namepack','somst')->where('fc_sono', session('fc_sono_global'))
        ->where('fc_branch', auth()->user()->fc_branch)
        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
        ->get();

        return DataTables::of($data)
            ->addColumn('total_harga', function ($item) {
                return $item->fn_so_qty * $item->fm_so_oriprice;
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables($fc_sostatus){
        if($fc_sostatus == "ALL") {
            $data = SoMaster::with('domst','customer')->where('fc_sotype', 'Cost Per Test')
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->get();
        } else {
            $data = SoMaster::with('domst','customer')->where('fc_sotype', 'Cost Per Test')
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_sostatus', $fc_sostatus)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->get();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function export_excel($status){
        if($status == 'pending'){
            return Excel::download(new CprrExport('P'), 'so_cprr_pending.xlsx');
        }else if($status == 'clear'){
            return Excel::download(new CprrExport('C'), 'so_cprr_clear.xlsx');
        }else if($status == 'dodone'){
            return Excel::download(new CprrExport('DD'), 'so_cprr_do_done.xlsx');
        }else if($status == 'menunggu'){
            return Excel::download(new CprrExport('F'), 'so_cprr_menunggu.xlsx');
        }else{
            return Excel::download(new CprrExport('A'), 'so_cprr_all.xlsx');
        }
    }

    public function cancel_so(Request $request){
        // ubah fc_sostatus yang fc_sono sama dengan $request->fc_sono

        $fc_sono = $request->fc_sono;

        // update
        $so_master = SoMaster::where('fc_sono', $fc_sono)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
        ->first();

        $update_status = $so_master->update([
            'fc_sostatus' => 'CC',
        ]);

        if ($update_status) {
            return [
                'status' => 201,
                'message' => 'Data berhasil dicancel',
                'link' => '/apps/daftar-cprr'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data gagal dicancel'
        ];
    }
}
