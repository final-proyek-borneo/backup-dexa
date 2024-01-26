<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;
use App\Models\PoDetail;
use PDF;
use Carbon\Carbon;
use File;
use DB;

use App\Models\PoMaster;
use App\Models\RoMaster;
use App\Models\RoDetail;
use App\Models\TempRoDetail;
use App\Models\TempRoMaster;
use App\Models\Warehouse;
use Yajra\DataTables\DataTables;

class ReceivingOrderController extends Controller
{
    public function index(){
        $data = TempRoMaster::where('fc_rono', auth()->user()->fc_userid)->first();

        $count = TempRoMaster::where('fc_rono', auth()->user()->fc_userid)->count();
        if ($count === 0) {
            return view('apps.receiving-order.index');
        } else {
            return redirect('/apps/receiving-order/create/' . base64_encode($data->fc_pono) . '/' . base64_encode($data->fc_pono));
        }
    }

    public function good_reception($fc_grno,$fc_suppliercode){
        $decode_fc_grno = base64_decode($fc_grno);
        $data = TempRoMaster::where('fc_rono', auth()->user()->fc_userid)->first();

        $count = TempRoMaster::where('fc_rono', auth()->user()->fc_userid)->count();
        $data['fc_grno'] = $decode_fc_grno ;
        $data['fc_suppliercode'] = $fc_suppliercode;

        //session fc_grno
        session(['fc_grno_global' => $decode_fc_grno]);
        // dd($data);
        if ($count === 0) {
            return view('apps.receiving-order.index_good_reception',$data);
        } else {
            return redirect('/apps/receiving-order/create/' . base64_encode($data->fc_pono));
        }
        // dd($fc_suppliercode);
    }

    public function detail($fc_pono){
        $decode_fc_pono = base64_decode($fc_pono);
        session(['fc_pono_global' => $decode_fc_pono]);
        $data['data'] = PoMaster::with('supplier')->where('fc_pono', $decode_fc_pono)->where('fc_branch', auth()->user()->fc_branch)->first();
        return view('apps.receiving-order.detail', $data);
        // dd($data);
    }

    public function datatables_po_detail($fc_pono)
    {
        $decode_fc_pono = base64_decode($fc_pono);
        // dd($decode_fc_pono);
        //  jika session fc_sono_global tidak sama dengan null
        if (session('fc_pono_global') != null) {
            $fc_pono = session('fc_pono_global');
            $data = PoDetail::with('branch', 'warehouse', 'stock', 'namepack')->where('fc_pono', $fc_pono)->where('fc_branch', auth()->user()->fc_branch)->where('fc_divisioncode', auth()->user()->fc_divisioncode)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        $data = PoDetail::with('branch', 'warehouse', 'stock', 'namepack')->where('fc_pono', $decode_fc_pono)->where('fc_branch', auth()->user()->fc_branch)->where('fc_divisioncode', auth()->user()->fc_divisioncode)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_warehouse(){
        $data = Warehouse::where('fc_branch', auth()->user()->fc_branch)->where('fc_warehousepos', 'INTERNAL')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    // public function pdf_ro($fc_rono)
    // {
    //     $decode_fc_rono = base64_decode($fc_rono);
    //     session(['fc_rono_global' => $decode_fc_rono]);
    //     $data['ro_mst'] = RoMaster::with('pomst')->where('fc_rono', $decode_fc_rono)->first();
    //     $data['ro_dtl'] = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', $decode_fc_rono)->get();
    //     $pdf = PDF::loadView('pdf.receiving-order-podetail', $data)->setPaper('a4');
    //     return $pdf->stream();
    // }

    public function pdf(Request $request){
        // dd($request);
        $decode_fc_rono = base64_encode($request->fc_rono);
        $data['ro_mst'] = RoMaster::with('pomst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl'] = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->get();
        if($request->name_pj){
            $data['nama_pj'] = $request->name_pj;
        }else{
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

    public function get_pdf($fc_rono,$nama_pj){
        $decode_fc_rono = base64_decode($fc_rono);
        $data['ro_mst'] = RoMaster::with('pomst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl'] = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['nama_pj'] = $nama_pj;
        $pdf = PDF::loadView('pdf.receiving-order', $data)->setPaper('a4');
        return $pdf->stream();
    }

    public function datatables_receiving_order($fc_pono)
    {
        $decode_fc_pono = base64_decode($fc_pono);
        $data = RoMaster::with('pomst.supplier')->where('fc_pono', $decode_fc_pono)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables()
    {
        $data = PoMaster::with('supplier')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function cancel_ro($fc_pono)
    {
        DB::beginTransaction();

        try {
            TempRoDetail::where('fc_rono', auth()->user()->fc_userid)->delete();
            TempRoMaster::where('fc_rono', auth()->user()->fc_userid)->delete();

            DB::commit();

            return [
                'status' => 201, // SUCCESS
                'link' => '/apps/receiving-order',
                'message' => 'BPB dibatalkan'
            ];
        } catch (\Exception $e) {

            DB::rollback();

            return [
                'status'     => 300, // GAGAL
                'message'       => (env('APP_DEBUG', 'true') == 'true') ? $e->getMessage() : 'Operation error'
            ];
        }
    }
}
