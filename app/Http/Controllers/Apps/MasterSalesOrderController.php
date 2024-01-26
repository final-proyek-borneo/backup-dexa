<?php

namespace App\Http\Controllers\Apps;

use App\Exports\SalesOrderExport;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;

use Yajra\DataTables\DataTables as DataTables;
use PDF;
use Carbon\Carbon;
use File;
use DB;

use App\Models\SoMaster;
use App\Models\SoDetail;
use App\Models\DoDetail;
use App\Models\TempSoPay;
use Maatwebsite\Excel\Facades\Excel;

class MasterSalesOrderController extends Controller
{

    public function index(){
        return view('apps.master-sales-order.index');
    }

    public function detail($fc_sono){
        // kalau encode pakai base64_encode
        // kalau decode pakai base64_decode
        $encoded_fc_sono = base64_decode($fc_sono);
        session(['fc_sono_global' => $encoded_fc_sono]);
        $data['data'] = SoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', $encoded_fc_sono)->where('fc_branch', auth()->user()->fc_branch)->first();
        return view('apps.master-sales-order.detail', $data);
        // dd($data);
    }

    public function datatables_so_payment(){
        $data = TempSoPay::where('fc_sono', session('fc_sono_global'))->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make();
    }

    public function datatables_so_detail()
    {
        $data = SoDetail::with('branch', 'warehouse', 'stock', 'namepack','somst')->where('fc_sono', session('fc_sono_global'))->get();

        return DataTables::of($data)
            ->addColumn('total_harga', function ($item) {
                return $item->fn_so_qty * $item->fm_so_oriprice;
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables($fc_sostatus){
        if($fc_sostatus == "ALL") {
            $data = SoMaster::with('domst','customer')->where('fc_sotype', 'Retail')->where('fc_branch', auth()->user()->fc_branch)->get();
        } else {
            $data = SoMaster::with('domst','customer')->where('fc_sotype', 'Retail')->where('fc_branch', auth()->user()->fc_branch)->where('fc_sostatus', $fc_sostatus)->get();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }
    
    public function pdf(Request $request){

        // $decoded_fc_dono = base64_decode($fc_dono);
        // $decoded_fc_sono = base64_decode($fc_sono);
        // session(['fc_sono_global' => $decoded_fc_sono]);
        $data['so_master'] = SoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', $request->fc_sono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['so_detail'] = SoDetail::with('stock')->where('fc_sono', $request->fc_sono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['so_payment'] = TempSoPay::with('transaksitype')->where('fc_sono', $request->fc_sono)->where('fc_branch', auth()->user()->fc_branch)->get();

        $data['do_detail'] = DoDetail::with('invstore.stock')
                                        ->where('fc_dono', $request->fc_dono)
                                        ->where('fc_branch', auth()->user()->fc_branch)
                                        ->get();
        
        if($request->name_pj){
            $data['nama_pj'] = $request->name_pj;
        }else{
            $data['nama_pj'] = auth()->user()->fc_username;
        }
        // $pdf = PDF::loadView('pdf.download-pdf', $data)->setPaper('a4');
        // return $pdf->stream();
        // dd($request);
        $encode_fc_sono = base64_encode($request->fc_sono);
        $encode_fc_dono = base64_encode($request->fc_dono);
        return [
            'status' => 201,
            'message' => 'PDF Berhasil ditampilkan',
            'link' => '/apps/master-sales-order/get_pdf/' . $encode_fc_dono  . '/' . $encode_fc_sono . '/' . $data['nama_pj'],
        ];

    }

    public function get_pdf($fc_dono, $fc_sono, $name_pj){
        $decoded_fc_dono = base64_decode($fc_dono);
        $decoded_fc_sono = base64_decode($fc_sono);
        session(['fc_sono_global' => $decoded_fc_sono]);
        $data['so_master'] = SoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', $decoded_fc_sono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['so_detail'] = SoDetail::with('stock')->where('fc_sono', $decoded_fc_sono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['so_payment'] = TempSoPay::with('transaksitype')->where('fc_sono', $decoded_fc_sono)->where('fc_branch', auth()->user()->fc_branch)->get();

        $data['do_detail'] = DoDetail::with('invstore.stock')
                                        ->where('fc_dono', $decoded_fc_dono)
                                        ->where('fc_branch', auth()->user()->fc_branch)
                                        ->get();
        
        if($name_pj){
            $data['nama_pj'] = $name_pj;
        }else{
            $data['nama_pj'] = auth()->user()->fc_username;
        }
        $pdf = PDF::loadView('pdf.download-pdf', $data)->setPaper('a4');
        return $pdf->stream();
    }

    public function close_so(Request $request){
        // ubah fc_sostatus yang fc_sono sama dengan $request->fc_sono

        $fc_sono = $request->fc_sono;
        $fc_sostatus = $request->fc_sostatus;

        // update
        $so_master = SoMaster::where('fc_sono', $fc_sono)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $so_master->update([
            'fc_sostatus' => $fc_sostatus,
        ]);


        if ($update_status) {
            return [
                'status' => 200,
                'message' => 'Data berhasil diclose',
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data gagal diclose'
        ];
    }

    public function cancel_so(Request $request){
        // ubah fc_sostatus yang fc_sono sama dengan $request->fc_sono

        $fc_sono = $request->fc_sono;

        // update
        $so_master = SoMaster::where('fc_sono', $fc_sono)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $so_master->update([
            'fc_sostatus' => 'CC',
        ]);

        if ($update_status) {
            return [
                'status' => 201,
                'message' => 'Data berhasil dicancel',
                'link' => '/apps/master-sales-order'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data gagal dicancel'
        ];
    }

    public function export_excel(Request $request, $status){
        if($status == 'pending'){
            return Excel::download(new SalesOrderExport('P', $request), 'so_master_pending.xlsx');
        }else if($status == 'clear'){
            return Excel::download(new SalesOrderExport('C', $request), 'so_master_clear.xlsx');
        }else if($status == 'dodone'){
            return Excel::download(new SalesOrderExport('DD', $request), 'so_master_do_done.xlsx');
        }else if($status == 'menunggu'){
            return Excel::download(new SalesOrderExport('F', $request), 'so_master_menunggu.xlsx');
        }else{
            return Excel::download(new SalesOrderExport('A', $request), 'so_master_all.xlsx');
        }

        // dd($request);
        // dd($status);

        
        return Excel::download(new SalesOrderExport, 'so_master_pending.xlsx');
      
    }
}
