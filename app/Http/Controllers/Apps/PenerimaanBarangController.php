<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\GoodReception;
use App\Models\Supplier;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class PenerimaanBarangController extends Controller
{
    public function index(){
        return view('apps.penerimaan-barang.index');
    }

    public function get_data_supplier_pb_datatables($fc_branch){
        $data = Supplier::with('branch','supplier_legal_status','supplier_nationality','supplier_type_business','supplier_tax_code','supplier_bank1','supplier_bank2','supplier_bank2','supplier_bank3','supplier_typebranch')->where('fc_branch', $fc_branch)->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function insert_good_reception(Request $request){
        // validation
        $validator = Validator::make($request->all(), [
            'fd_arrivaldate' => 'required',
            'fc_recipient' => 'required',
            'fc_suppliercode' => 'required',
            'fn_qtyitem' => 'required',
            'fc_unit' => 'required',
        ]);

        // jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // formatting tanggal untuk store DB
        $arrivalDate = Carbon::createFromFormat('m/d/Y', $request->fd_arrivaldate)->format('Y-m-d H:i:s');

        $insert_good_reception = GoodReception::create([
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_grno' => auth()->user()->fc_userid,
            'fd_arrivaldate' => $arrivalDate,
            'fc_recipient' => $request->fc_recipient,
            'fc_suppliercode' => $request->fc_suppliercode,
            'fn_qtyitem' => $request->fn_qtyitem,
            'fc_unit' => $request->fc_unit,
        ], $request->all());

        if ($insert_good_reception) {
            return [
                'status' => 201,
                'message' => 'Data berhasil disimpan',
                'link' => '/apps/penerimaan-barang'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Data gagal disimpan',
            ];
        }
        // dd($arrivalDate);
    }
}
