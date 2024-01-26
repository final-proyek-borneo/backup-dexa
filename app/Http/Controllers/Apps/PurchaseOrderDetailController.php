<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\TempPoDetail;
use App\Models\TempPoMaster;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class PurchaseOrderDetailController extends Controller
{
    public function datatables()
    {
        $data = TempPoDetail::with('branch', 'warehouse', 'namepack', 'temppomst')
        ->join('t_stock', 't_stock.fc_stockcode', '=', 't_temppodtl.fc_stockcode')
        ->where('t_temppodtl.fc_pono', auth()->user()->fc_userid)
        ->select('t_temppodtl.*', 't_stock.*')
        ->get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function store_update(Request $request)
    {
        //  validasi request
        $validator = Validator::make($request->all(), [
            // 'fc_stockcode' => 'required',
            'fc_stockcode' => 'required',
            'fc_barcode' => 'required',
            'fn_po_qty' => 'required|integer|min:1',
            'fm_po_price' => 'required',
        ], [
            // 'fc_stockcode.required' => 'Barcode harus diisi',
            'fc_stockcode.required' => 'Kode Barang harus diisi',
            'fn_so_qty.required' => 'Quantity harus diisi',
            'fm_po_price' => 'Harga harus diisi'
        ]);
        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $count_po_dtl = TempPoDetail::where('fc_pono', auth()->user()->fc_userid)->get();
        $total = count($count_po_dtl);

        $stock = Stock::where('fc_stockcode', $request->fc_stockcode)->first();
        $temp_detail = TempPoDetail::where('fc_pono', auth()->user()->fc_userid)->orderBy('fn_porownum', 'DESC')->first();

        // jika ada TempSoDetail yang fc_stockcode == $request->fc_stockcode
        $count_stockcode = TempPoDetail::where('fc_pono', auth()->user()->fc_userid)->where('fc_stockcode', $request->fc_stockcode)->get();


        // jika ada fc_stockcode yang sama di $temppodtl
        if (!empty($temp_detail)) {
            // jika ditemukan $count_barcode error produk yang sama telah diinputkan
            if (count($count_stockcode) > 0) {
                return [
                    'status' => 300,
                    'total' => $total,
                    'message' => 'Produk yang sama telah diinputkan'
                ];
            }
        }


        $fn_porownum = 1;
        if (!empty($temp_detail)) {
            $fn_porownum = $temp_detail->fn_porownum + 1;
        }

        $stock = Stock::where('fc_stockcode', $request->fc_stockcode)->first();
        $request->merge(['fm_po_price' => Convert::convert_to_double($request->fm_po_price)]);
        //total harga
        $total_harga = $request->fn_po_value * $request->fm_po_price;

        $request->merge(['fn_po_qty' => Convert::convert_to_double($request->fn_po_qty)]);
        $request->merge(['fn_po_value' => Convert::convert_to_double($total_harga)]);
        
        // dd($request->fm_po_price);
        $insert_po_detail = TempPoDetail::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_pono' => auth()->user()->fc_userid,
            'fn_porownum' => $fn_porownum,
            // 'fc_stockcode' => $stock->fc_stockcode,
            'fc_barcode' => $request->fc_barcode,
            'fc_stockcode' => $request->fc_stockcode,
            'fc_namepack' => $stock->fc_namepack,
            'fn_po_qty' => $request->fn_po_qty,
            'fn_po_value' => $request->fn_po_qty * $request->fm_po_price_edit,
            'fm_po_price' => $request->fm_po_price,
            'fv_description' => $request->fv_description,
            'fd_stockarrived' => ($request->fd_stockarrived==='') ? NULL : $request->fd_stockarrived,
        ]);

        if ($insert_po_detail) {
            return response()->json([
                'status' => 200,
                'total' => $total,
                'link' => '/apps/purchase-order',
                'message' => 'Data berhasil disimpan'
            ]);
        }
        return [
            'status' => 300,
            'link' => '/apps/purchase-order',
            'message' => 'Error'
        ];
    }

    public function delete($fc_pono, $fn_porownum)
    {
        // hitung jumlah data di TempPoDetail
        $count_po_dtl = TempPoDetail::where('fc_pono', $fc_pono)->where('fc_branch', auth()->user()->fc_branch)->count();
        $delete = TempPoDetail::where('fc_pono', $fc_pono)->where('fn_porownum', $fn_porownum)->delete();
        if ($delete) {
            if($count_po_dtl < 2){
                return response()->json([
                    'status' => 201,
                    'message' => 'Data berhasil dihapus',
                    'link' => '/apps/purchase-order'
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil dihapus'
            ]);
        }
        return [
            'status' => 300,
            'message' => 'Error'
        ];
    }

    public function received_update($fc_pono, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fd_podateinputuser' => 'required',
            'fc_potransport' => 'required',
            'fc_memberaddress_loading1' => 'required',
            'fd_poexpired' => 'required'
        ], [
            'fd_podateinputuser' => 'Tanggal harus diisi',
            'fc_potransport.required' => 'Transport harus diisi',
            'fc_memberaddress_loading1.required' => 'Alamat Tujuan harus diisi',
            'fd_poexpired.required' => 'Tanggal Expired harus diisi'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
        $temp_po_master = TempPoMaster::where('fc_pono', $fc_pono)->first();
        $request->merge(['fm_servpay' => Convert::convert_to_double($request->fm_servpay)]);
        $update_tempomst = $temp_po_master->update([
            'fd_podateinputuser' => $request->fd_podateinputuser,
            'fc_potransport' => $request->fc_potransport,
            'fm_servpay' => $request->fm_servpay,
            'fv_description' => $request->fv_description,
            'fc_destination' => $request->fc_membername1,
            'fc_address_loading1' => $request->fc_memberaddress_loading1,
            'fd_poexpired' => date('Y-m-d H:i:s', strtotime($request->fd_poexpired)),
        ]);


        $temp_po_master = TempPoMaster::with('branch', 'supplier_tax_code', 'sales', 'supplier.supplier_type_business', 'supplier.supplier_typebranch', 'supplier.supplier_legal_status')->where('fc_pono', auth()->user()->fc_userid)->first();
        $data = [];
        if (!empty($temp_po_master)) {
            $data['data'] = $temp_po_master;
        }

     if($update_tempomst){
        return [
            'status' => 201,
            // 'data' => $data,
            'message' => 'Data berhasil disimpan',
            // link
            'link' => route('po_index')
        ];
        // dd($request);
      }

      return [
        'status' => 300,
        'message' => 'Error'
      ];
    }

    public function submit(Request $request){

        // jumlah item PO detail
        $temp_detail = TempPoDetail::where('fc_pono', auth()->user()->fc_userid)->get();
        $total = count($temp_detail);

        // get total pembayaran
        $data_bayar = TempPoDetail::where('fc_pono', auth()->user()->fc_userid)->get();
        $total_bayar = 0;
        foreach ($data_bayar as $key => $value) {
            $total_bayar += $value->fm_po_price * $value->fn_po_qty;
        }


        // validasi
        $validator = Validator::make($request->all(), [
            'fd_podateinputuser' => 'required',
            'fd_poexpired' => 'required',
        ], [
            'fd_podateinputuser.required' => 'Date Order harus diisi',
            'fd_poexpired.required' => 'Date Expired harus diisi',
        ]);

        // jika validasi gagal
        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => 'Date Order atau Date Expired Kosong',
            ];
        } else {
            // insert into TempSoMaster
            if ($total == 0) {
                return [
                    'status' => 300,
                    'message' => 'Tambahkan Item terlebih dahulu',
                ];
            }

            DB::beginTransaction();
         
            try {
                $temp_po_master = TempPoMaster::where('fc_pono', auth()->user()->fc_userid)->update([
                    'fc_postatus' => 'F',
                    'fd_podatesysinput' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
                // dd($request);
                // tampilkan data yang di update dari $temp_so_master


                TempPoDetail::where('fc_pono', auth()->user()->fc_userid)->delete();
                TempPoMaster::where(['fc_pono' => auth()->user()->fc_userid])->delete();

                DB::commit();
                if ($temp_po_master) {
                    return [
                        'status' => 201, // SUCCESS
                        'link' => '/apps/purchase-order',
                        'message' => 'Submit Purchase Order Berhasil'
                    ];
                }
            } catch (\Exception $e) {

                DB::rollBack();

                return [
                    'status'     => 300, // GAGAL
                    'message'       => (env('APP_DEBUG', 'true') == 'true') ? $e->getMessage() : 'Operation error'
                ];
            }

            // jika update berhasil
            // if ($temp_so_master) {
            //     // Tambahkan session flash message
            //     // session()->flash("message", "Pembayaran Berhasil"); 

            //     // // Kirim data message yang didapat dari session
            //     // $message = session()->get("message");
            //     return response()->json(["status" => 200, "message" => "Pembayaran Berhasil"]);
            // }

            return [
                'status' => 300,
                'message' => 'Data gagal disimpan',
            ];
        }
        // dd($request);
    }
}
