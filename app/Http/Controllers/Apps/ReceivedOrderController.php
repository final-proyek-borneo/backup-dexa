<?php

namespace App\Http\Controllers\Apps;

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

use App\Models\SoMaster;
use App\Models\SoDetail;
use App\Models\TempSoPay;
use App\Models\Invstore;
use App\Models\DoDetail;
use App\Models\DoMaster;
use Yajra\DataTables\DataTables;

class ReceivedOrderController extends Controller
{
    public function index(){
        return view('apps.received-order.index');
    }

    // public function cari_do($fc_dono){
    //     $decode_fc_dono = base64_decode($fc_dono);
    //     // dd($decode_fc_dono);
    //     $do_master = DoMaster::where('fc_dono', $decode_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();
    //     if(empty($do_master)){
    //         return [
    //             'status' => 300,
    //             'message' => 'No Delivery Order Tidak ditemukan'
    //         ];
    //     }

    //     return [
    //         'status' => 201,
    //         'link' => '/apps/received-order/detail/' . $fc_dono,
    //         'message' => 'DO ditemukan, tunggu sebentar anda akan dialihkan ke halaman Detail',
    //     ];
    // }

    public function detail($fc_dono){
        $decode_fc_dono = base64_decode($fc_dono);
        $data['data'] = DoMaster::with('somst','dodtl')->where('fc_dono', $decode_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();
        return view('apps.received-order.detail', $data);
    }

    public function datatables(request $request){
        $data = DoDetail::with('invstore.stock')->where('fc_dono', $request->fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make();
    }

    public function action_confirm(request $request){
        DoMaster::where('fc_dono', $request->fc_dono)->update([
            'fd_doarivaldate' => date('Y-m-d H:i:s', strtotime($request->fd_doarivaldate)),
            'fc_transporter' => $request->fc_transporter,
            'fc_custreceiver' => $request->fc_custreceiver,
            'fc_dostatus' => 'R'
        ]);

        return [
            'status' => 201,
            'link' => '/apps/received-order',
            'message' => 'Surat Jalan berhasil diterima'
        ];
    }
}
