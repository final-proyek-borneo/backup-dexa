<?php

namespace App\Http\Controllers\Apps;

use DB;
use PDF;
use auth;
use File;
use Carbon\Carbon;
use App\Models\User;
use App\Helpers\Convert;

use App\Models\DoDetail;
use App\Models\DoMaster;
use App\Models\Invstore;
use App\Models\InvMaster;

use App\Helpers\NoDocument;
use App\Models\TempDoDetail;
use App\Models\TempDoMaster;
use Illuminate\Http\Request;
use App\Exports\SuratJalanExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables as DataTables;

class MasterDeliveryOrderController extends Controller
{

    public function index()
    {
        $data['do_mst'] = TempDoMaster::with('somst.customer')->first();

        return view('apps.master-delivery-order.index', $data);
    }

    public function detail($fc_dono)
    {
        // kalau encode pakai base64_encode
        // kalau decode pakai base64_decode
        $encoded_fc_dono = base64_decode($fc_dono);
        session(['fc_dono_global' => $encoded_fc_dono]);
        $data['do_mst'] = TempDoMaster::with('somst.customer')->where('fc_dono', $encoded_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl'] = TempDoDetail::with('invstore.stock')->where('fc_dono', $encoded_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();
        return view('apps.master-delivery-order.detail', $data);
        // dd($data);
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fc_dostatus' => 'required',
            'fc_dono' => 'required'
        ], [
            'fc_dostatus.required' => 'Pilih Reject Terlebih Dahulu',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $decoded_dono = base64_decode($request->fc_dono);
        // update data fc_dostatus in DoMaster
        $do_mst = TempDoMaster::where('fc_dono', $decoded_dono)
            ->update([
                'fc_dostatus' => $request->fc_dostatus,
            ]);

        // jika validasi sukses dan $do_master berhasil response 200
        if ($do_mst) {
            return response()->json(
                [
                    'status' => 201,
                    'message' => 'Submit berhasil',
                    'link' => '/apps/master-delivery-order'
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 300,
                    'message' => 'Submit gagal'
                ]
            );
        }
        // dd($request);
    }

    public function editDo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fc_dostatus' => 'required',
            'fc_dono' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // Transaction update data fc_dostatus in DoMaster dan DODTL
        DB::beginTransaction();
        try {
            TempDoDetail::where('fc_dono', $request->fc_dono)->update(['fc_dono' => auth()->user()->fc_userid]);
            TempDoMaster::where('fc_dono', $request->fc_dono)->update(['fc_dostatus' => $request->fc_dostatus, 'fc_dono' => auth()->user()->fc_userid]);
            DB::commit();

            return [
                'status' => 201, // SUCCESS
                'link' => '/apps/delivery-order',
                'message' => 'DO Berhasil di Edit'
            ];
        } catch (\Exception $e) {

            DB::rollback();

            return [
                'status'     => 300, // GAGAL
                'message'       => (env('APP_DEBUG', 'true') == 'true') ? $e->getMessage() : 'Operation error'
            ];
        }
        // dd($request);
    }

    public function datatables($fc_dostatus)
    {
        if ($fc_dostatus == "ALL") {
            $data = DoMaster::with('somst.customer')->where('fc_branch', auth()->user()->fc_branch)
                ->whereIn('fc_dostatus', ['D', 'P', 'CC', 'L', 'R'])
                ->get();
        } elseif ($fc_dostatus == "APR") {
            $data = TempDoMaster::with('somst.customer')->where('fc_branch', auth()->user()->fc_branch)
                ->whereIn('fc_dostatus', ['NA', 'AC', 'RJ'])
                ->get();
        } else {
            $data = DoMaster::with('somst.customer')->where('fc_branch', auth()->user()->fc_branch)->where('fc_dostatus', $fc_dostatus)->get();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function datatables_do_detail($fc_dono)
    {
        $decode_dono = base64_decode($fc_dono);
        $data = TempDoDetail::with('domst', 'invstore.stock')->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_dono', $decode_dono)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($fc_dono);
    }

    public function datatables_detail(Request $request)
    {
        $data = DoMaster::with('somst.customer')->where('fc_dono', $request->fc_dono)->first();;

        // return response json
        return response()->json($data);
    }

    public function datatables_invstore($fc_stockcode, $fc_warehousecode, $fc_barcode)
    {
        $data = Invstore::with('stock')
            ->where('fc_stockcode', $fc_stockcode)
            ->where('fn_quantity', '>', 0)
            ->where('fc_warehousecode', $fc_warehousecode)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->orWhere(function (Builder $query) use ($fc_barcode, $fc_warehousecode) {
                $query->where('fc_barcode', $fc_barcode)
                    ->where('fc_warehousecode', $fc_warehousecode);
            })
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function cancel(Request $request)
    {
        // ubah fc_sostatus yang fc_sono sama dengan $request->fc_sono

        $fc_dono = $request->fc_dono;

        // update
        $do_master = DoMaster::where('fc_dono', $fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $do_master->update([
            'fc_dostatus' => 'CC',
        ]);

        if ($update_status) {
            return [
                'status' => 201,
                'message' => 'Data berhasil dicancel',
                'link' => '/apps/master-delivery-order'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data gagal dicancel'
        ];
    }

    public function pdf(Request $request)
    {
        // dd($request);
        $encode_fc_dono = base64_encode($request->fc_dono);
        $data['do_mst'] = DoMaster::with('somst')->where('fc_dono', $request->fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl'] = DoDetail::with('invstore.stock')->where('fc_dono', $request->fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();
        if ($request->name_pj) {
            $data['nama_pj'] = $request->name_pj;
        } else {
            $data['nama_pj'] = auth()->user()->fc_username;
        }
        // $pdf = PDF::loadView('pdf.purchase-order', $data)->setPaper('a4');
        // return $pdf->stream();
        // dd($data);

        //redirect ke /apps/master-receiving-order/pdf dengan mengirimkan $data
        return [
            'status' => 201,
            'message' => 'PDF Berhasil ditampilkan',
            'link' => '/apps/master-delivery-order/get_pdf/' . $encode_fc_dono . '/' . $data['nama_pj'],
        ];
        // dd($data['do_dtl']);
    }

    public function get_pdf($fc_dono, $nama_pj)
    {
        $decode_fc_dono = base64_decode($fc_dono);
        $data['do_mst'] = DoMaster::with('somst')->where('fc_dono', $decode_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl'] = DoDetail::with('invstore.stock')->where('fc_dono', $decode_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['nama_pj'] = $nama_pj;
        $data['user'] = User::where('fc_userid', $nama_pj)->where('fc_branch', auth()->user()->fc_branch)->first();
        $pdf = PDF::loadView('pdf.report-do', $data)->setPaper('a4');
        return $pdf->stream();
    }

    public function pdf_sj(Request $request)
    {
        // dd($request);
        $encode_fc_dono = base64_encode($request->fc_dono);
        $data['do_mst'] = DoMaster::with('somst')->where('fc_dono', $request->fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl'] = DoDetail::with('invstore.stock')->where('fc_dono', $request->fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();
        if ($request->name_pj) {
            $data['nama_pj'] = $request->name_pj;
        } else {
            $data['nama_pj'] = auth()->user()->fc_username;
        }

        return [
            'status' => 201,
            'message' => 'PDF Berhasil ditampilkan',
            'link' => '/apps/master-delivery-order/get-sj/' . $encode_fc_dono . '/' . $data['nama_pj'],
        ];
    }

    public function get_pdf_sj($fc_dono, $nama_pj)
    {
        $decode_fc_dono = base64_decode($fc_dono);
        $data['do_mst'] = DoMaster::with('somst')->where('fc_dono', $decode_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl'] = DoDetail::with('invstore.stock')->where('fc_dono', $decode_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['nama_pj'] = $nama_pj;
        $data['user'] = User::where('fc_userid', $nama_pj)->where('fc_branch', auth()->user()->fc_branch)->first();
        $pdf = PDF::loadView('pdf.surat-jalan', $data)
            ->setPaper('a4')
            ->setOption([
                'fontDir' => storage_path('fonts/'),
                'font_cache' => storage_path('fonts/')
            ]);

        return $pdf->stream();
    }

    public function inv($fc_dono)
    {
        $decode_fc_dono = base64_decode($fc_dono);
        session(['fc_dono_global' => $decode_fc_dono]);
        $data['do_mst'] = DoMaster::with('somst')->where('fc_dono', $decode_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl'] = DoDetail::with('invstore.stock')->where('fc_dono', $decode_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();
        // get data invmaster
        $data['inv_mst'] = InvMaster::where('fc_dono', $decode_fc_dono)->first();
        $pdf = PDF::loadView('pdf.invoice', $data)->setPaper('a4');
        return $pdf->stream();
    }

    public function publish(Request $request)
    {
        // validasi semua request
        //    dd($request);
        $validator = Validator::make(
            $request->all(),
            [
                'fc_dono' => 'required',
                'fc_divisioncode' => 'required',
                'fc_branch' => 'required',
                //   'fn_dodateinputuser' => 'required',
                'fn_dodetail' => 'required',
                'fm_disctotal' => 'required',
                'fm_netto' => 'required',
                'fm_servpay' => 'required',
                'fm_tax' => 'required',
                'fm_brutto' => 'required',
                'fd_inv_releasedate' => 'required',
                'fn_inv_agingday' => 'required',
                'fd_inv_agingdate' => 'required'
            ],
            [
                // pesan validasi
                'fc_dono' => 'Nomor DO tidak boleh kosong',
                'fc_divisioncode' => 'Kode Divisi tidak boleh kosong',
                // 'fn_dodateinputuser' => 'Tanggal DO tidak boleh kosong',
                'fd_inv_releasedate' => 'Tanggal Terbit Invoice tidak boleh kosong',
                'fn_inv_agingday' => 'Masa Invoice tidak boleh kosong',
                'fd_inv_agingdate' => 'Tanggal Jatuh Tempo Invoice tidak boleh kosong',
            ]
        );

        // apabila validasi tidak sesuai
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // create  data in InvMaster
        $inv_mst = InvMaster::Create(
            // ['fc_dono' => $request->fc_dono],
            [
                'fc_dono' => $request->fc_dono,
                'fc_branch' => $request->fc_branch,
                'fc_invno' => auth()->user()->fc_userid,
                'fc_sono' => $request->fc_sono,
                'fc_invtype' => 'OTG',
                'fc_divisioncode' => $request->fc_divisioncode,
                'fn_invdetail' => $request->fn_dodetail,
                'fm_disctotal' => $request->fm_disctotal,
                'fm_netto' => $request->fm_netto,
                'fc_userid' => auth()->user()->fc_userid,
                'fm_servpay' => $request->fm_servpay,
                'fm_tax' => $request->fm_tax,
                'fm_brutto' => $request->fm_brutto,
                'fd_inv_releasedate' => $request->fd_inv_releasedate,
                'fn_inv_agingday' => $request->fn_inv_agingday,
                'fd_inv_agingdate' => $request->fd_inv_agingdate,
                'fd_inv_releasedate' => $request->fd_inv_releasedate,
            ]
        );


        // // update data fc_invstatus in DoMaster
        // $do_mst = DoMaster::where('fc_dono', $request->fc_dono)->update(['fc_invstatus' => 'Y']);

        // // jika validasi sukses dan $do_master berhasil response 200
        if ($inv_mst) {
            return response()->json(
                [
                    'status' => 200,
                    'message' => 'Invoice berhasil diterbitkan',
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 300,
                    'message' => 'Invoice gagal diterbitkan'
                ]
            );
        }
    }


    public function reject_approval(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fc_dostatus' => 'required',
            'fv_description' => 'required',
            'fc_dono' => 'required'
        ], [
            'fc_dostatus.required' => 'Pilih Reject Terlebih Dahulu',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // update data fc_dostatus in DoMaster
        $do_mst = TempDoMaster::where('fc_dono', $request->fc_dono)
            ->update([
                'fc_dostatus' => $request->fc_dostatus,
                'fv_description' => $request->fv_description,
            ]);

        // jika validasi sukses dan $do_master berhasil response 200
        if ($do_mst) {
            return response()->json(
                [
                    'status' => 201,
                    'message' => 'Reject berhasil',
                    'link' => '/apps/master-delivery-order'
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 300,
                    'message' => 'Reject gagal'
                ]
            );
        }
    }

    public function accept_approval(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fc_dostatus' => 'required',
            'fc_dono' => 'required'
        ], [
            'fc_dostatus.required' => 'Pilih Accept Terlebih Dahulu',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        // update data fc_dostatus in DoMaster
        $do_mst = TempDoMaster::where('fc_dono', $request->fc_dono)
            ->update([
                'fc_dostatus' => $request->fc_dostatus,
            ]);

        // jika validasi sukses dan $do_master berhasil response 200
        if ($do_mst) {
            return response()->json(
                [
                    'status' => 201,
                    'message' => 'Accept berhasil',
                    'link' => '/apps/master-delivery-order'
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 300,
                    'message' => 'Accept gagal'
                ]
            );
        }
    }


    public function export_excel($status)
    {
        if ($status == 'kirim') {
            return Excel::download(new SuratJalanExport('D'), 'do_master_Kirim.xlsx');
        } else if ($status == 'diterima') {
            return Excel::download(new SuratJalanExport('R'), 'do_master_diterima.xlsx');
        } else if ($status == 'approval') {
            return Excel::download(new SuratJalanExport('AC'), 'do_master_approve.xlsx');
        } else {
            return Excel::download(new SuratJalanExport('A'), 'do_master_all.xlsx');
        }
    }
}
