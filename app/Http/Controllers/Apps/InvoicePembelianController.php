<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use App\Models\DoDetail;
use App\Models\DoMaster;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use PDF;
use App\Models\PoMaster;
use App\Models\RoMaster;
use App\Models\RoDetail;
use App\Models\InvDetail;
use App\Models\InvMaster;
use App\Models\InvoiceMst;
use App\Models\Supplier;
use App\Models\TempInvoiceDtl;
use App\Models\TempInvoiceMst;
use App\Models\TransaksiType;
use App\Helpers\ApiFormatter;
use Carbon\Carbon;
use Validator;

class InvoicePembelianController extends Controller
{
    public function index(){
        $temp_inv_master = TempInvoiceMst::with('customer')->where('fc_invno', auth()->user()->fc_userid)->where('fc_invtype', 'PURCHASE')->where('fc_branch', auth()->user()->fc_branch)->first();
        $temp_detail = TempInvoiceDtl::where('fc_invno', auth()->user()->fc_userid)->get();

        $total = count($temp_detail);
        
        if (!empty($temp_inv_master)) {
            // $fc_child_suppdocno = json_decode($temp_inv_master->fc_child_suppdocno, true);
            $fc_child_suppdocno = [$temp_inv_master->fc_child_suppdocno];
            $data['temp'] = TempInvoiceMst::with('romst', 'pomst', 'bank')->where('fc_invno',auth()->user()->fc_userid)->first();

            if (count($fc_child_suppdocno) > 0 && is_array($fc_child_suppdocno)) {
                $values = array_map(function ($jsonString) {
                    return json_decode($jsonString, true);
                }, $fc_child_suppdocno);
                
                $query =  RoMaster::with('pomst.supplier')
                    ->where(function ($query) use ($values) {
                        $query->whereIn('fc_rono', array_merge(...$values));
                    })
                    ->where('fc_branch', auth()->user()->fc_branch);

                $data['ro_mst'] = $query->get();

                $data['ro_dtl'] = RoDetail::with('invstore.stock')
                    ->where(function ($query) use ($values) {
                        $query->whereIn('fc_rono', array_merge(...$values));
                    })
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->get();
            } else {
                $data['ro_mst'] = RoMaster::with('pomst.supplier')
                    ->where('fc_rono', $fc_child_suppdocno[0])
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->first();

                $data['ro_dtl'] = RoDetail::with('invstore.stock')
                    ->where('fc_rono', $fc_child_suppdocno[0])
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->get();
            }

            return view('apps.invoice-pembelian.create', $data);
            // dd($fc_child_suppdocno);
            // dd($data['ro_mst']);
        }
        return view('apps.invoice-pembelian.index');     
    }

    public function detail($fc_rono)
    {
        $decode_fc_rono = base64_decode($fc_rono);
        session(['fc_rono_global' => $decode_fc_rono]);
        $data['ro_mst'] = RoMaster::with('pomst.supplier', 'warehouse')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl'] = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['fc_rono'] = $decode_fc_rono;

        $temp_inv_master = TempInvoiceMst::with('supplier')->where([
            'fc_invno' =>  auth()->user()->fc_userid,
            'fc_branch' =>  auth()->user()->fc_branch,
            'fc_invtype' => "PURCHASE"
        ])->first();
        if(!empty($temp_inv_master)){
            $data['temp'] = TempInvoiceMst::with('romst', 'pomst', 'bank')->where('fc_invno',auth()->user()->fc_userid)->first();
            $data['ro_mst'] = RoMaster::with('pomst.supplier')->where('fc_rono', $temp_inv_master->fc_child_suppdocno)->where('fc_branch', auth()->user()->fc_branch)->first();
            $data['ro_dtl'] = RoDetail::with('invstore.stock')->where('fc_rono', $temp_inv_master->fc_child_suppdocno)->where('fc_branch', auth()->user()->fc_branch)->get();
            return view('apps.invoice-pembelian.create',$data);
            // dd($temp_inv_master->fc_child_suppdocno);
        }
        $data['temp'] = TempInvoiceMst::with('romst', 'pomst', 'bank')->where('fc_invno',auth()->user()->fc_userid)->first();
        $data['ro_mst'] = RoMaster::with('pomst.supplier')->where('fc_rono', $decode_fc_rono )->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl'] = RoDetail::with('invstore.stock')->where('fc_rono', $decode_fc_rono )->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['fc_rono'] = $decode_fc_rono;
        
        return view('apps.invoice-pembelian.detail', $data);
    }

    public function datatables()
    {
        $data = RoMaster::with('pomst.supplier')->where('fc_rostatus', 'R')
        ->where('fc_invstatus', '!=', 'INV')
        ->where('fc_branch', auth()->user()->fc_branch)
        ->get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_ro_detail()
    {
        $data = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', session('fc_rono_global'))->where('fc_branch', auth()->user()->fc_branch)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function create_invoice(Request $request){
        // validator
        $validator = Validator::make($request->all(), [
            'fc_suppdocno' => 'required',
            'fc_entitycode' => 'required'
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
        
        $temp_inv_master = TempInvoiceMst::where('fc_invno', auth()->user()->fc_userid)->where('fc_invtype', 'PURCHASE')->where('fc_branch', auth()->user()->fc_branch)->first();

        if(empty($temp_inv_master)){
        $fc_child_suppdocno_array = explode(',', $request->fc_child_suppdocno);
        $fc_child_suppdocno_json = json_encode($fc_child_suppdocno_array, JSON_UNESCAPED_SLASHES);
             // create TempInvoiceMst
         $create = TempInvoiceMst::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_invno' => auth()->user()->fc_userid,
            'fc_suppdocno' => $request->fc_suppdocno,
            'fc_child_suppdocno' => $fc_child_suppdocno_json,
            'fc_entitycode' => $request->fc_entitycode,
            'fc_status' => 'I',
            'fc_invtype' => 'PURCHASE',
            'fd_inv_releasedate' => date('Y-m-d H:i:s', strtotime($request->fd_inv_releasedate)),
            'fn_inv_agingday' => $request->fn_inv_agingday,
            'fd_inv_agingdate' => date('Y-m-d H:i:s', strtotime($request->fd_inv_agingdate)),
            'fc_userid' => auth()->user()->fc_userid,
            'fn_invdetail' => $request->fn_dodetail
         ]);

            if($create){
                return [
                    'status' => 201,
                    'message' => 'Data berhasil disimpan',
                    'link' => '/apps/invoice-pembelian/create/' . base64_encode( $request->fc_child_suppdocno)
                ];
            }else{
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];
            }
        }else{
            return [
                'status' => 300,
                'message' => 'Data sudah ada'
            ];
        }
       
    }

    public function supplier()
    {
        $data = Supplier::with(
            'branch',
            'supplier_legal_status',
            'supplier_nationality',
            'supplier_type_business',
            'supplier_tax_code',
            'supplier_typebranch',
            'supplier_bank1',
            'supplier_bank2',
            'supplier_bank3',
        )->get();
        return ApiFormatter::getResponse($data);
    }

    public function datatables_po($fc_suppliercode){
        $decoded_fc_suppliercode = base64_decode($fc_suppliercode);
        // jika $decoded_fc_membercode samadengan 'all' maka tampilkan semua data
        if($decoded_fc_suppliercode == 'all'){

            $data = PoMaster::with('romst','supplier')->where('fc_branch', auth()->user()->fc_branch)->where('fc_potype', 'PO Beli')->where('fc_invstatus', '!=' ,'INV')->whereNotIn('fc_postatus', ['L', 'CC', 'F'])->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        }

        $data = PoMaster::with('romst','supplier')->where('fc_branch', auth()->user()->fc_branch)->where('fc_potype', 'PO Beli')->where('fc_invstatus', '!=' ,'INV')->where('fc_suppliercode', $decoded_fc_suppliercode)->whereNotIn('fc_postatus', ['L', 'CC', 'F'])->orderBy('fc_pono')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function datatables_bpb($fc_pono){
        $decoded_fc_pono = base64_decode($fc_pono);
        // jika $decoded_fc_sono samadengan 'all' maka tampilkan semua data
        if($decoded_fc_pono == 'all'){
            $data = RoMaster::with('pomst.supplier')->whereNotIn('fc_rostatus', ['L', 'CC'])
            ->where('fc_invstatus', '!=', 'INV')
            ->where('fc_branch', auth()->user()->fc_branch)
            ->get();
        } else {
            $data = RoMaster::with('pomst.supplier')->whereNotIn('fc_rostatus', ['L', 'CC'])
            ->where('fc_invstatus', '!=', 'INV')
            ->where('fc_pono', $decoded_fc_pono)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->orderBy('fc_rono')
            ->get();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function create_invoice_multibpb(Request $request){
        // validator
        $validator = Validator::make($request->all(), [
            'fc_pono' => 'required',
            'fc_suppliercode' => 'required',
            'fc_rono' => 'required'
        ]);

        // pesan required custom replaced $validator
        $validator->customMessages = [
            'fc_pono.required' => 'PO wajib diisi',
            'fc_suppliercode.required' => 'Supplier wajib diisi',
            'fc_rono.required' => 'BPB Performa wajib diisi'
        ];
        
        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        // ambil fc_dodetail in domaster
        $fn_rodetail = RoMaster::where('fc_pono', $request->fc_pono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $temp_inv_master = TempInvoiceMst::where('fc_invno', auth()->user()->fc_userid)->where('fc_invtype', 'PURCHASE')->where('fc_branch', auth()->user()->fc_branch)->first();

        if(empty($temp_inv_master)){
        $fc_rono_array = explode(',', $request->fc_rono);

        // JSON-encoded string
        $fc_rono_json = json_encode($fc_rono_array, JSON_UNESCAPED_SLASHES);

            // create TempInvoiceMst
         $create = TempInvoiceMst::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_invno' => auth()->user()->fc_userid,
            'fc_suppdocno' => $request->fc_pono,
            'fc_child_suppdocno' =>  $fc_rono_json,
            'fc_entitycode' => $request->fc_suppliercode,
            'fc_status' => 'I',
            'fc_invtype' => 'PURCHASE',
            'fd_inv_releasedate' => date('Y-m-d H:i:s', strtotime($request->fd_inv_releasedate)),
            'fn_inv_agingday' => $request->fn_inv_agingday,
            'fd_inv_agingdate' => date('Y-m-d H:i:s', strtotime($request->fd_inv_agingdate)),
            'fc_userid' => auth()->user()->fc_userid,
            'fn_invdetail' => $fn_rodetail
         ]);

            if($create){
                return [
                    'status' => 201,
                    'message' => 'Data berhasil disimpan',
                    'link' => '/apps/invoice-pembelian/create/multibpb/' . base64_encode($fc_rono_json)
                ];
            }else{
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];
            }
        // dd($request);
        }else{
            return [
                'status' => 300,
                'message' => 'Data sudah ada'
            ];
        }

        
    }
}
