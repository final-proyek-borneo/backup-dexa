<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use PDF;
use App\Models\RoMaster;
use App\Models\RoDetail;
use App\Models\SoMaster;
use App\Models\DoMaster;
use App\Models\DoDetail;
use App\Models\InvDetail;
use App\Models\InvMaster;
use App\Models\TempInvoiceDtl;
use App\Models\TempInvoiceMst;
use App\Models\TransaksiType;
use Carbon\Carbon;
use App\Helpers\ApiFormatter;
use App\Models\Customer;
use Validator;

class InvoicePenjualanController extends Controller
{
    public function index(){
            $temp_inv_master = TempInvoiceMst::with('customer')->where('fc_invno', auth()->user()->fc_userid)->where('fc_invtype', 'SALES')->where('fc_branch', auth()->user()->fc_branch)->first();
            $temp_detail = TempInvoiceDtl::where('fc_invno', auth()->user()->fc_userid)->get();

            $total = count($temp_detail);
            
            if (!empty($temp_inv_master)) {
                $fc_child_suppdocno = json_decode($temp_inv_master->fc_child_suppdocno, true);
                $fc_child_suppdocno = [$temp_inv_master->fc_child_suppdocno];
                $data['temp'] = TempInvoiceMst::with('domst', 'somst', 'bank')->where('fc_invno', auth()->user()->fc_userid)->first();

                if (count($fc_child_suppdocno) > 0 && is_array($fc_child_suppdocno)) {
                    $values = array_map(function ($jsonString) {
                        return json_decode($jsonString, true);
                    }, $fc_child_suppdocno);

                    $query = DoMaster::with('somst.customer')
                        ->where(function ($query) use ($values) {
                            $query->whereIn('fc_dono', array_merge(...$values));
                        })
                        ->where('fc_branch', auth()->user()->fc_branch);

                    $data['do_mst'] = $query->get();

                    $data['do_dtl'] = DoDetail::with('invstore.stock')
                        ->where(function ($query) use ($values) {
                            $query->whereIn('fc_dono', array_merge(...$values));
                        })
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->get();
                } else {
                    $data['do_mst'] = DoMaster::with('somst.customer')
                        ->where('fc_dono', $fc_child_suppdocno[0])
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->first();

                    $data['do_dtl'] = DoDetail::with('invstore.stock')
                        ->where('fc_dono', $fc_child_suppdocno[0])
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->get();
                }

                return view('apps.invoice-penjualan.create', $data);
                // dd($fc_child_suppdocno);
            }

            return view('apps.invoice-penjualan.index');
        }


    public function datatables()
    {
        $data = DoMaster::with('somst.customer')->where('fc_dostatus', 'R')
        ->where('fc_invstatus', '!=', 'INV')
        ->where('fc_branch', auth()->user()->fc_branch)
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function detail($fc_dono){
        $decoded_fc_dono = base64_decode($fc_dono);
        session(['fc_dono_global' => $decoded_fc_dono ]);
        $temp_inv_master = TempInvoiceMst::with('customer')->where([
            'fc_invno' =>  auth()->user()->fc_userid,
            'fc_branch' =>  auth()->user()->fc_branch,
            'fc_invtype' => "SALES"
        ])->first();
        if(!empty($temp_inv_master)){
            $data['do_mst'] = DoMaster::with('somst.customer')->where('fc_dono', $temp_inv_master->fc_child_suppdocno)->where('fc_branch', auth()->user()->fc_branch)->first();
            $data['do_dtl'] = DoDetail::with('invstore.stock')->where('fc_dono', $temp_inv_master->fc_child_suppdocno)->where('fc_branch', auth()->user()->fc_branch)->get();
            return view('apps.invoice-penjualan.create',$data);
            // dd($temp_inv_master->fc_child_suppdocno);
        }
        $data['do_mst'] = DoMaster::with('somst.customer')->where('fc_dono', $decoded_fc_dono )->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl'] = DoDetail::with('invstore.stock')->where('fc_dono', $decoded_fc_dono )->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['fc_dono'] = $decoded_fc_dono;
        
        return view('apps.invoice-penjualan.detail', $data);
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

        $temp_inv_master = TempInvoiceMst::where('fc_invno', auth()->user()->fc_userid)->where('fc_invtype', 'SALES')->where('fc_branch', auth()->user()->fc_branch)->first();

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
            'fc_invtype' => 'SALES',
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
                    'link' => '/apps/invoice-penjualan/create/' . base64_encode( $request->fc_child_suppdocno)
                ];
            }else{
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];
            }

        // dd($fc_child_suppdocno_json);
        }else{
            return [
                'status' => 300,
                'message' => 'Data sudah ada'
            ];
        }

        
    }

    public function create_invoice_multisj(Request $request){
        // validator
        $validator = Validator::make($request->all(), [
            'fc_sono' => 'required',
            'fc_membercode' => 'required',
            'fc_dono' => 'required'
        ]);

        // pesan required custom replaced $validator
        $validator->customMessages = [
            'fc_sono.required' => 'SO wajib diisi',
            'fc_membercode.required' => 'Customer wajib diisi',
            'fc_dono.required' => 'Surat Jalan wajib diisi'
        ];
        
        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        // ambil fc_dodetail in domaster
        $fn_dodetail = DoMaster::where('fc_sono', $request->fc_sono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $temp_inv_master = TempInvoiceMst::where('fc_invno', auth()->user()->fc_userid)->where('fc_invtype', 'SALES')->where('fc_branch', auth()->user()->fc_branch)->first();

        if(empty($temp_inv_master)){
        $fc_dono_array = explode(',', $request->fc_dono);

        // JSON-encoded string
        $fc_dono_json = json_encode($fc_dono_array, JSON_UNESCAPED_SLASHES);

            // create TempInvoiceMst
         $create = TempInvoiceMst::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_invno' => auth()->user()->fc_userid,
            'fc_suppdocno' => $request->fc_sono,
            'fc_child_suppdocno' =>  $fc_dono_json,
            'fc_entitycode' => $request->fc_membercode,
            'fc_status' => 'I',
            'fc_invtype' => 'SALES',
            'fd_inv_releasedate' => date('Y-m-d H:i:s', strtotime($request->fd_inv_releasedate)),
            'fn_inv_agingday' => $request->fn_inv_agingday,
            'fd_inv_agingdate' => date('Y-m-d H:i:s', strtotime($request->fd_inv_agingdate)),
            'fc_userid' => auth()->user()->fc_userid,
            'fn_invdetail' => $fn_dodetail
         ]);

            if($create){
                return [
                    'status' => 201,
                    'message' => 'Data berhasil disimpan',
                    'link' => '/apps/invoice-penjualan/create/multisj/' . base64_encode($fc_dono_json)
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

    public function customer()
    {
        $data = Customer::with('member_tax_code', 'member_typebranch', 'member_type_business', 'member_legal_status')->get();
        return ApiFormatter::getResponse($data);
    }

    public function datatables_so($fc_membercode){
        $decoded_fc_membercode = base64_decode($fc_membercode);
        // jika $decoded_fc_membercode samadengan 'all' maka tampilkan semua data
        if($decoded_fc_membercode == 'all'){

            $data = SoMaster::with('domst','customer')->where('fc_branch', auth()->user()->fc_branch)->where('fc_invstatus', '!=' ,'INV')->where('fc_sotype', 'Retail')->whereNotIn('fc_sostatus', ['L', 'CC', 'F'])->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        }

        $data = SoMaster::with('domst','customer')->where('fc_branch', auth()->user()->fc_branch)->where('fc_invstatus', '!=' ,'INV')->where('fc_membercode', $decoded_fc_membercode)->where('fc_sotype', 'Retail')->whereNotIn('fc_sostatus', ['L', 'CC', 'F'])->orderBy('fc_sono')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function datatables_sj($fc_sono){
        $decoded_fc_sono = base64_decode($fc_sono);
        // jika $decoded_fc_sono samadengan 'all' maka tampilkan semua data
        if($decoded_fc_sono == 'all'){
            $data = DoMaster::with('somst.customer')->whereNotIn('fc_dostatus', ['L', 'CC'])
            ->where('fc_invstatus', '!=', 'INV')
            ->where('fc_branch', auth()->user()->fc_branch)
            ->get();
        } else {
            $data = DoMaster::with('somst.customer')->whereNotIn('fc_dostatus', ['L', 'CC'])
            ->where('fc_invstatus', '!=', 'INV')
            ->where('fc_sono', $decoded_fc_sono)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->orderBy('fc_dono')
            ->get();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);

        // dd($data);
    }
}
