<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\TransaksiType;

class MetaDataController extends Controller
{
    public function index()
    {
        return view('data-master.meta-data.index');
    }

    public function detail($fc_trx,$fc_kode)
    {
        return TransaksiType::where('fc_kode', $fc_kode)->where('fc_trx', $fc_trx)->first();
    }

    public function datatables()
    {
        $data = TransaksiType::orderBy('fc_trx', 'ASC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function add_transaksi_type(Request $request){
        $validator = Validator::make($request->all(), [
            'fc_trx' => 'required',
            'fc_kode' => 'required',
            'fv_description' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        if (empty($request->type)) {
            $cek_data = TransaksiType::where([
                'fc_trx' => $request->fc_trx,
                'fc_kode' => $request->fc_kode,
            ])->whereNull('deleted_at')->withTrashed()->count();

            if ($cek_data > 0) {
                return [
                    'status' => 300,
                    'message' => 'Oops! Insert gagal karena data sudah ditemukan didalam sistem kami'
                ];
            }
        }

        // cek jika ada fc_trx dan fc_kode yang sama dengan request
        $exist_data = TransaksiType::where([
            'fc_trx' => $request->fc_trx,
            'fc_kode' => $request->fc_kode,
        ])->whereNull('deleted_at')->withTrashed()->count();

        // munculkan pesan 300
        if ($exist_data > 0) {
            return [
                'status' => 300,
                'message' => 'Oops! Insert gagal karena data sudah ditemukan didalam sistem kami'
            ];
        }

        $add_transaksi = TransaksiType::create([
            'fc_trx' => $request->fc_trx,
            'fc_kode' => $request->fc_kode,
            'fv_description' => $request->fv_description,
            'fc_action' => $request->fc_action
        ] );

        if ($add_transaksi) {
            return [
                'status' => 200, // SUCCESS
                'message' => 'Data berhasil disimpan'
            ];
        }

        return [
            'status' => 300, // SUCCESS
            'message' => 'Data gagal disimpan'
        ];
        // dd($request->fc_action);
    }

    public function store_update(request $request){
        $validator = Validator::make($request->all(), [
            'fc_trx' => 'required',
            'fc_kode' => 'required',
            'fv_description' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $transaksi_type = TransaksiType::where(['fc_trx' => $request->fc_trx, 'fc_kode' => $request->fc_kode])->first();
        $update_transaksi_type = $transaksi_type->update([
            'fv_description' => $request->fv_description,
            'fc_action' => $request->fc_action
        ]);

        if ($update_transaksi_type) {
            return [
                'status' => 200, // SUCCESS
                'message' => 'Data berhasil disimpan'
            ];
        }

        return [
            'status' => 300, // SUCCESS
            'message' => 'Data gagal disimpan'
        ];
    }

    public function delete($fc_kode)
    {
        TransaksiType::where('fc_kode', $fc_kode)->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }
}
