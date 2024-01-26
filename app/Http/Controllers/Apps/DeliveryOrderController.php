<?php

namespace App\Http\Controllers\Apps;

use DB;
use PDF;
use File;
use Carbon\Carbon;
use App\Models\Stock;
use App\Helpers\Convert;

use App\Models\DoDetail;
use App\Models\DoMaster;
use App\Models\Invstore;
use App\Models\SoDetail;

use App\Models\SoMaster;
use App\Models\TempSoPay;
use App\Models\Warehouse;
use App\Helpers\NoDocument;
use App\Models\TempDoDetail;
use App\Models\TempDoMaster;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DeliveryOrderController extends Controller
{

    public function index()
    {
        // cari di domst yang userid nya sama dengan userid yang login
        $do_master = TempDoMaster::where('fc_dono', auth()->user()->fc_userid)->first();
        // jika $do_master tidak kosong return ke route create_do
        if (!empty($do_master)) {
            return redirect()->route('create_do');
        }

        return view('apps.delivery-order.index');
        // dd($do_master);
    }

    public function detail($fc_sono)
    {
        $encode_fc_sono = base64_decode($fc_sono);
        session(['fc_sono_global' => $encode_fc_sono]);
        $cek_status = SoMaster::where(
            'fc_sono',
            $encode_fc_sono
        )->first();

        // jika statusnya "L" dan "C" maka kirimkan warning
        if ($cek_status->fc_sostatus == "L" || $cek_status->fc_sostatus == "C") {
            return redirect()->route('do_index')->with('warning', 'SO sudah di proses');
        }
        $data['data'] = Warehouse::where('fc_branch', auth()->user()->fc_branch)->first();
        $data['data'] = SoMaster::with('branch', 'member_tax_code', 'sales', 'customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')
            ->where('fc_sono', $encode_fc_sono)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->first();

        return view('apps.delivery-order.detail', $data);
        // dd($fc_divisioncode);
    }

    public function insert_do(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fc_divisioncode' => 'required',
            'fc_sono' => 'required',
            'fc_warehousecode' => 'required',
            'fc_sostatus' => 'required',
            // 'fc_userid' => 'required',
            'fc_dono' => 'required',
        ], [
            'fc_divisioncode.required' => 'Division Code tidak boleh kosong',
            'fc_sono.required' => 'SO Number tidak boleh kosong',
            'fc_warehousecode.required' => 'Gudang tidak boleh kosong',
            'fc_sostatus.required' => 'SO Status tidak boleh kosong',
            // 'fc_userid.required' => 'User ID tidak boleh kosong',
            'fc_dono.required' => 'DO Number tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $so_master = SoMaster::where('fc_sono', $request->fc_sono)
            ->where('fc_divisioncode', $request->fc_divisioncode)
            ->where('fc_branch', $request->fc_branch)->first();
        // dd($so_master->fc_salescode);

        // cek apakah Do sudah ada apa belum berdasarkan dono dari userid yang login
        $temp_do_master = TempDoMaster::where('fc_dono', $request->fc_dono)->first();
        if (!empty($temp_do_master)) {
            return response()->json(
                [
                    'status' => 200,
                    'message' => 'Edit Do'
                ]
            );
        }

        // dd($so_master);

        $create_temp_do_master = TempDoMaster::create([
            'fc_divisioncode' => $request->fc_divisioncode,
            'fc_branch' => $request->fc_branch,
            'fc_sono' => $request->fc_sono,
            'fc_warehousecode' => $request->fc_warehousecode,
            'fc_sostatus' => $request->fc_sostatus,
            'fc_userid' => auth()->user()->fc_userid,
            'fc_dono' => $request->fc_dono,
            'fc_dostatus' => 'I',
            'fc_salescode' => $so_master->fc_salescode,
            'fc_sotransport' => $so_master->fc_sotransport,
            'fm_servpay' => $so_master->fm_servpay,
            'fc_memberaddress_loading' => $so_master->fc_memberaddress_loading1,
        ]);

        // // jika validasi sukses dan $do_master berhasil response 200
        if ($create_temp_do_master) {
            return response()->json(
                [
                    'status' => 200,
                    'message' => 'Insert Do'
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 300,
                    'message' => 'Gagal Buat DO'
                ]
            );
        }
    }

    public function create()
    {
        $temp_domst = TempDoMaster::where('fc_dono', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->first();
        $fc_sono_domst = $temp_domst->fc_sono;
        $data['data'] = SoMaster::with('branch', 'member_tax_code', 'sales', 'customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status', 'domst')
            ->where('fc_sono', $fc_sono_domst)
            ->first();
        $data['domst'] = $temp_domst;
        return view('apps.delivery-order.do', $data);
        // dd($data);
    }

    public function datatables_so_payment()
    {
        $data = TempSoPay::where('fc_sono', session('fc_sono_global'))->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make();
    }

    public function datatables_stock_inventory($fc_stockcode)
    {
        // decode fc_stockcode
        $decode_fc_stockcode = base64_decode($fc_stockcode);
        // get data from Invstore
        $now_fc_warehousecode = TempDoMaster::where('fc_dono', auth()->user()->fc_userid)
            ->where('fc_branch', auth()->user()->fc_branch)->first()->fc_warehousecode;
        $data = Invstore::with('stock.sodtl.somst', 'warehouse')
            ->where('fc_stockcode', $decode_fc_stockcode)
            ->where('fn_quantity', '>', 0)
            ->where('fd_expired', '>', Carbon::now())
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_warehousecode', $now_fc_warehousecode)
            ->orderBy('fd_expired', 'ASC')
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_so_detail($fc_sono)
    {
        $decode_fc_sono = base64_decode($fc_sono);
        $data = SoDetail::with('branch', 'warehouse', 'stock', 'namepack', 'somst.tempdomst')->where('fc_sono', $decode_fc_sono)->get();

        return DataTables::of($data)
            ->addColumn('total_harga', function ($item) {
                return $item->fn_so_qty * $item->fm_so_oriprice;
            })
            ->addIndexColumn()
            ->make(true);
        // dd($domst);
    }

    public function datatables()
    {
        $data = SoMaster::with('customer')
            ->where('fc_sotype', 'Retail')
            ->whereIn('fc_sostatus', ['F', 'P'])
            ->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_warehouse()
    {
        $data = Warehouse::where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }



    public function cart_stock(request $request)
    {
        // jika request ada 'quantity'
        if ($request->quantity) {
            $validator = Validator::make($request->all(), [
                'fc_barcode' => 'required',
                'quantity' => 'required',
                'fc_stockcode' => 'required'
            ]);
        } else if ($request->bonus_quantity) {
            $validator = Validator::make($request->all(), [
                'fc_barcode' => 'required',
                'bonus_quantity' => 'required',
                'fc_stockcode' => 'required'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'fc_barcode' => 'required',
                'quantity' => 'required',
                'bonus_quantity' => 'required',
                'fc_stockcode' => 'required'
            ]);
        }


        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $now_fc_warehousecode = TempDoMaster::where('fc_dono', auth()->user()->fc_userid)
            ->where('fc_branch', auth()->user()->fc_branch)->first()->fc_warehousecode;

        //CHECK DATA STOCK
        $data_stock = Invstore::where('fc_barcode', $request->fc_barcode)
            ->where('fc_warehousecode', $now_fc_warehousecode)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->first();

        $data_temp_dodtl = TempDoDetail::where('fc_dono', auth()->user()->fc_userid)
            ->where('fc_barcode', $request->fc_barcode)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->first();

        $data_stock_sodtl = SoDetail::where('fc_stockcode', $request->fc_stockcode)
            ->where('fc_sono', $request->fc_sono)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->first();
            
       
        $qty = $data_stock_sodtl->fn_so_qty - $data_stock_sodtl->fn_do_qty;
        
        // if ($qty >= $data_stock->fn_quantity) {
            if ($request->quantity > $data_stock->fn_quantity) {
                return [
                    'status' => 300,
                    'message' => 'Quantity yang anda masukkan melebihi stock yang tersedia'
                ];
            }
        // }

        // dd($request->quantity);
        if ($request->quantity > $qty) {
            return [
                'status' => 300,
                'message' => 'Quantity yang diinputkan melebihi jumlah pesanan'
            ];
        }

        if ($request->bonus_quantity > ($data_stock_sodtl->fn_so_bonusqty - $data_stock_sodtl->fn_do_bonusqty)) {
            return [
                'status' => 300,
                'message' => 'Quantity yang diinputkan melebihi jumlah pesanan'
            ];
        }

        // // // Stock kosong
        if ($data_stock->fn_quantity == 0) {
            return [
                'status' => 300,
                'message' => 'Stock Kosong'
            ];
        }

        // // //INSERT DoDetail dari data stock
        // echo ($request->fc_barcode);
        if ($request->quantity) {
            if (empty($data_temp_dodtl)) {
                $do_dtl = TempDoDetail::create([
                    'fc_divisioncode' => auth()->user()->fc_divisioncode,
                    'fc_branch' => auth()->user()->fc_branch,
                    'fc_dono' => auth()->user()->fc_userid,
                    'fc_barcode' => $request->fc_barcode,
                    'fn_qty_do' => $request->quantity,
                    'fc_status_bonus_do' => 'F',
                    'fc_namepack' => $data_stock->stock->fc_namepack,
                    'fc_batch' => $data_stock->fc_batch,
                    'fc_catnumber' => $data_stock->fc_catnumber,
                    'fd_expired' => $data_stock->fd_expired,
                    'fn_price' => $data_stock_sodtl->fm_so_price,
                    'fn_disc' => $data_stock_sodtl->fm_so_disc,
                ]);
            } else {
                return [
                    'status' => 300,
                    'message' => 'Data gagal ditambahkan, terdapat duplikasi Item! Silahkan hapus Item yang tersimpan!'
                ];
            }
        } else {
            $do_dtl = TempDoDetail::create([
                'fc_divisioncode' => $data_stock->fc_divisioncode,
                'fc_branch' => $data_stock->fc_branch,
                'fc_dono' => auth()->user()->fc_userid,
                'fc_barcode' => $request->fc_barcode,
                'fn_qty_do' => $request->bonus_quantity,
                'fc_status_bonus_do' => 'T',
                'fc_namepack' => $data_stock->stock->fc_namepack,
                'fc_batch' => $data_stock->fc_batch,
                'fc_catnumber' => $data_stock->fc_catnumber,
                'fd_expired' => $data_stock->fd_expired,
                'fn_price' => 0,
                'fn_disc' => 0,
            ]);
        }

        if ($do_dtl) {
            return [
                'status' => 200,
                'message' => 'Data berhasil ditambahkan'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Data gagal ditambahkan'
            ];
        }
    }


    // datatable deliver item
    public function datatables_do_detail()
    {
        $data = TempDoDetail::with('invstore.stock', 'domst')->where('fc_dono', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd(auth()->user()->fc_userid);
    }

    public function delete_item($fc_barcode, $fn_rownum)
    {

        // validasi $fc_barcode require
        $validator = Validator::make(
            ['fc_barcode' => $fc_barcode],
            ['fc_barcode' => 'required',]
        );

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        // jumlah DoDetail
        $count_do_detail = TempDoDetail::where('fc_barcode', $fc_barcode)->where('fc_branch', auth()->user()->fc_branch)->count();

        // hapus
        $hapus_item = TempDoDetail::where(
            [
                'fc_barcode' => $fc_barcode,
                'fn_rownum' => $fn_rownum
            ]
        )->delete();
        // kemudian tambah
        if ($hapus_item) {
            if ($count_do_detail < 2) {
                return [
                    'status' => 201,
                    'message' => 'Data berhasil dihapus',
                    'link' => '/apps/delivery-order/create_do'
                ];
            }
            return [
                'status' => 200,
                'message' => 'Data berhasil dihapus'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Data gagal dihapus'
            ];
        }
    }


    public function update_transport(Request $request, $fc_sono)
    {
        // validasi $fc_sono require
        $validator = Validator::make(
            [
                'fc_sono' => base64_decode($fc_sono),
                'fc_transporter' => $request->fc_transporter,
                'fm_servpay' => $request->fm_servpay,
                'fc_sotransport' => $request->fc_sotransport,
                'fd_dodate' => $request->fd_dodate,
                'fc_memberaddress_loading' => $request->fc_memberaddress_loading,
            ],
            [
                'fc_sono' => 'required',
                'fc_transporter' => 'required',
                'fm_servpay' => 'required',
                'fc_sotransport' => 'required',
                'fd_dodate' => 'required',
                'fc_memberaddress_loading' => 'required',
            ]
        );

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
        // dd($request);

        $request->merge(['fm_servpay' => Convert::convert_to_double($request->fm_servpay)]);
        $fd_dodate = date('Y-m-d H:i:s', strtotime($request->fd_dodate));
        $update_transport = TempDoMaster::where('fc_dono', auth()->user()->fc_userid)
            ->update([
                'fc_sotransport' => $request->fc_sotransport,
                'fc_transporter' => $request->fc_transporter,
                // $request->fd_dodatesysinput convert format datetime,
                'fd_dodate' => $fd_dodate,
                'fm_servpay' => $request->fm_servpay,
                'fc_memberaddress_loading' => $request->fc_memberaddress_loading
            ]);

        // jika $update_transport bisa
        if ($update_transport) {
            return [
                'status' => 201,
                'message' => 'Data berhasil diupdate',
                'link' => '/apps/delivery-order/create_do'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Data gagal diupdate',
                //link

            ];
        }
    }

    public function cancel_do()
    {
        DB::beginTransaction();

        try {
            TempDoDetail::where('fc_dono', auth()->user()->fc_userid)->delete();
            TempDoMaster::where('fc_dono', auth()->user()->fc_userid)->delete();

            DB::commit();

            return [
                'status' => 201, // SUCCESS
                'link' => '/apps/delivery-order/',
                'message' => 'Berhasil Membatalkan Delivery Order'
            ];
        } catch (\Exception $e) {

            DB::rollback();

            return [
                'status'     => 300, // GAGAL
                'message'       => (env('APP_DEBUG', 'true') == 'true') ? $e->getMessage() : 'Operation error'
            ];
        }
    }

    public function submit_do(Request $request)
    {
        // validasi all request
        $validator = Validator::make($request->all(), [
            'fc_sostatus' => 'required',
            'fc_dostatus' => 'required',
            'fd_dodatesysinput' => 'required',
        ], [
            'fc_sostatus.required' => 'SO Status tidak boleh kosong',
            'fc_dostatus' => 'DO Status tidak boleh kosong',
            'fd_dodatesysinput.required' => 'Tanggal Input tidak boleh kosong',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $do_dtl = TempDoDetail::where('fc_dono', auth()->user()->fc_userid)->get();
        $do_mst = TempDoMaster::where('fc_dono', auth()->user()->fc_userid)->first();
        // jika fd_dodate,fc_sotransport,fc_transporter,fc_memberaddress_loading, fm_servpay di domst masih kosong
        if ($do_mst->fd_dodate == null || $do_mst->fc_sotransport == null || $do_mst->fc_transporter == null || $do_mst->fc_memberaddress_loading == null || $do_mst->fm_servpay === null) {
            return [
                'status' => 300,
                'message' => 'Data transport belum lengkap'
            ];
        }


        //jika do detail kosong
        if ($do_dtl->isEmpty()) {
            return [
                'status' => 300,
                'message' => 'Delivery Item Kosong'
            ];
        }

        //DB Transaction Submit
        DB::beginTransaction();

        try {
            // update
            TempDoMaster::where('fc_dono', auth()->user()->fc_userid)
                ->update([
                    'fc_sostatus' => $request->fc_sostatus,
                    'fc_dostatus' => $request->fc_dostatus,
                    'fd_dodatesysinput' => $request->fd_dodatesysinput,
                ]);

            TempDoDetail::where('fc_dono', auth()->user()->fc_userid)
                ->where('fc_branch', auth()->user()->fc_branch)
                ->delete();

            TempDoMaster::where('fc_dono', auth()->user()->fc_userid)
                ->where('fc_branch', auth()->user()->fc_branch)
                ->delete();

            DB::commit();

            return [
                'status' => 201,
                'link' => '/apps/delivery-order/',
                'message' => 'Data berhasil disubmit'
            ];
        } catch (\Exception $e) {
            DB::rollback();

            return [
                'status' => 300,
                'message' => (env('APP_DEBUG', 'true') == 'true') ? $e->getMessage() : 'Operation error'
            ];
        }
    }

    public function approve()
    {
        $isApproved = TempDoDetail::where('fc_dono', auth()->user()->fc_userid)
            ->where('fc_approval', 'T')
            ->exists();

        return response()->json(['approval' => $isApproved]);
    }
}
