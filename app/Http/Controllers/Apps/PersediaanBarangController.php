<?php

namespace App\Http\Controllers\Apps;

use App\Exports\KartuStockExport;
use App\Exports\WarehouseExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Convert;

use Validator;
use PDF;

use Carbon\Carbon;
use DB;
use Yajra\DataTables\DataTables;
use App\Models\Invstore;
use App\Models\Warehouse;
use App\Models\MutasiMaster;
use App\Models\Stock;
use App\Models\StockInquiri;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;

class PersediaanBarangController extends Controller
{
    public function index()
    {
        return view('apps.persediaan-barang.index');
    }

    public function detail($fc_warehousecode)
    {
        $fc_warehousecode = base64_decode($fc_warehousecode);
        $data['gudang_mst'] = Warehouse::where('fc_warehousecode', $fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->first();
        return view('apps.persediaan-barang.detail', $data);
        // dd($data);
    }

    public function datatables_detail($fc_warehousecode)
    {
        $data = Invstore::with('stock')
            ->select('fc_stockcode', DB::raw('SUM(fn_quantity) as fn_quantity'))
            ->where('fc_warehousecode', $fc_warehousecode)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->groupBy('fc_stockcode')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_detail_inventory($fc_stockcode, $fc_warehousecode)
    {
        $decode_fc_stockcode = base64_decode($fc_stockcode);
        $data = Invstore::with('stock')->where('fc_stockcode', $decode_fc_stockcode)->where('fc_warehousecode', $fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_mutasi($fc_warehousecode)
    {
        $data = MutasiMaster::with('warehouse')
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where(function ($query) use ($fc_warehousecode) {
                $query->where('fc_startpoint_code', $fc_warehousecode)
                    ->orWhere('fc_destination_code', $fc_warehousecode);
            })
            ->get();
        // $data = MutasiDetail::with('stock')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_dexa()
    {
        $data = Warehouse::where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->where('fc_warehousepos', 'INTERNAL')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sum_quantity', function ($row) {
                $groupedInvstore = Invstore::where('fc_warehousecode', $row->fc_warehousecode)
                    ->selectRaw("SUBSTRING(fc_barcode, 1, 40) as grouped_barcode, COUNT(*) as count")
                    ->groupBy('grouped_barcode')
                    ->get();

                $sumQuantity = $groupedInvstore->count();

                return $sumQuantity;
            })
            ->make(true);
    }

    public function datatables_gudanglain()
    {
        $data = Warehouse::where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->where('fc_warehousepos', 'EXTERNAL')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sum_quantity', function ($row) {
                $groupedInvstore = Invstore::where('fc_warehousecode', $row->fc_warehousecode)
                    ->selectRaw("SUBSTRING(fc_barcode, 1, 40) as grouped_barcode, COUNT(*) as count")
                    ->groupBy('grouped_barcode')
                    ->get();

                $sumQuantity = $groupedInvstore->count();

                return $sumQuantity;
            })
            ->make(true);
    }

    public function datatables_semua()
    {
        ini_set('memory_limit', '2048M'); // 2GB
        set_time_limit(360);
        $data = Stock::where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sum_quantity', function ($row) {
                $sumQuantity = $row->invstore->sum('fn_quantity');
                return $sumQuantity;
            })
            ->make(true);
            // ini_restore('max_execution_time');
    }

    public function datatables_inventory_dexa($fc_stockcode)
    {
        $data = Invstore::with(['stock', 'warehouse' => function ($query) {
            $query->where('fc_warehousepos', 'INTERNAL');
        }])
            ->where('fc_stockcode', $fc_stockcode)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->get();

        $filteredData = $data->filter(function ($item) {
            return $item->warehouse !== null;
        });

        return DataTables::of($filteredData)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_inventory_gudanglain($fc_stockcode)
    {
        $data = Invstore::with('stock')->where('fc_stockcode', $fc_stockcode)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function pdf($fc_warehousecode)
    {
        ini_set('memory_limit', '2048M'); // 2GB
        set_time_limit(360);
        $decode_fc_warehousecode = base64_decode($fc_warehousecode);
        session(['fc_warehousecode_global' => $decode_fc_warehousecode]);
        $data['gudang_mst'] = Warehouse::where('fc_warehousecode', $decode_fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['gudang_dtl'] = Invstore::with('stock')->where('fc_warehousecode', $decode_fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->get();

        $pdf = PDF::loadView('pdf.gudang', $data)->setPaper('a4');
        return $pdf->stream();
        // dd($data['gudang_dtl']);
    }

    public function export_excel(Request $request){
      ini_set('memory_limit', '2048M'); // 2GB
        set_time_limit(360);
        $decode_fc_warehousecode = base64_decode($request->fc_warehousecode);
        return Excel::download(new WarehouseExport($decode_fc_warehousecode), 'rekap_persediaan_barang.xlsx');
    }

    public function get_warehouse(){
        $data['warehouse'] = Warehouse::where('fc_branch', auth()->user()->fc_branch)->where('fc_divisioncode', auth()->user()->fc_divisioncode)->get();

        return response()->json($data);
    }

    public function get_stock(){
        $data['stock'] = Stock::where('fc_divisioncode', auth()->user()->fc_divisioncode)->where('fc_branch', auth()->user()->fc_branch)->get();

        return response()->json($data);
    }

    // public function export_kartu_stock(Request $request){
    //     ini_set('memory_limit', '2048M'); // 2GB
    //     set_time_limit(360);
    //     $startDate = $request->start_date;
    //     $endDate = $request->end_date;
    //     $warehouseFilter = $request->warehousefilter;
    //     $filename = 'Kartu Stok : ' . now()->format('Y-m-d_His') . '.xlsx';
    //     $range_date = date('d M Y', strtotime($startDate)) . ' - ' . date('d M Y', strtotime($endDate));
    //     $query = StockInquiri::with('warehouse', 'invstore.stock')
    //         ->where('fc_branch', auth()->user()->fc_branch);
    
    //     if (!empty($startDate)) {
    //         $query->where('fd_inqdate', '>=', $startDate);
    //     }
    
    //     if (!empty($endDate)) {
    //         $query->where('fd_inqdate', '<=', $endDate);
    //     }
    
    //     if (!empty($warehouseFilter)) {
    //         $query->where('fc_warehousecode', $warehouseFilter);
    //     }
    
    //     $kartuStock = $query->orderBy('fc_warehousecode')->orderBy('fd_inqdate')->get();
    
    //     return Excel::download(new KartuStockExport($kartuStock, $range_date), $filename);
    // }

    // from SQL Script
    public function export_kartu_stock(Request $request){
        ini_set('memory_limit', '2048M'); // 2GB
        set_time_limit(360);
        $startDate = $request->start_date;
        $endDate = $request->end_date;
    
        // Ubah format tanggal ke timestamp
        $startTimestamp = date('Y-m-d H:i:s', strtotime($startDate));
        $endTimestamp = date('Y-m-d H:i:s', strtotime($endDate));
        $warehouseFilter = $request->warehousefilter;
    
        $filename = 'Kartu Stok : ' . now()->format('Y-m-d_His') . '.xlsx';
        $range_date = date('d M Y', strtotime($startDate)) . ' - ' . date('d M Y', strtotime($endDate));
    
        // SQL Script kartu stock
        $kartuStock = DB::select("SELECT 
                a.fc_stockcode, 
                SUBSTRING(b.fc_barcode,1,LENGTH(a.fc_stockcode)) AS fc_stockcode_substring,
                b.fc_barcode, 
                d.fc_batch, 
                d.fd_expired, 
                c.created_at, 
                b.max_trans, 
                a.fc_nameshort, 
                a.fc_namelong, 
                a.fc_brand, 
                fc_group, 
                fc_subgroup, 
                fc_typestock1, 
                fc_typestock2,
                fn_in, 
                fn_out,
                c.fc_docreference, 
                COALESCE(c.fv_description,'') AS fv_description, 
                d.fn_quantity, 
                c.fc_warehousecode, 
                CASE 
                    WHEN e.fc_warehousepos = 'INTERNAL' THEN 'W/H INTERNAL DEXA'
                    WHEN e.fc_warehousepos = 'EXTERNAL' THEN CONCAT('W/H ', e.fc_membername1)
                    ELSE 'UN-IDENTIFIED W/H'
                END AS warehouse_name
            FROM t_stock a
        -- Mengambil posisi inquery ( tanggal terakhir masing-masing barcode dari t_inquiri )
        -- menggunakan max(created_ar) yang di group by fc_barcode
            LEFT OUTER JOIN (
                SELECT fc_barcode, MAX(created_at) AS max_trans
                FROM t_inquiri 
                GROUP BY fc_barcode
            ) b ON a.fc_stockcode = SUBSTRING(b.fc_barcode,1,LENGTH(a.fc_stockcode))
            LEFT OUTER JOIN t_inquiri c ON b.fc_barcode = c.fc_barcode AND c.created_at = b.max_trans
            LEFT OUTER JOIN t_invstore d ON d.fc_barcode = c.fc_barcode AND d.fc_warehousecode = c.fc_warehousecode
            LEFT OUTER JOIN (
                SELECT a.fc_warehousecode, a.fc_warehousepos, b.fc_membername1 
                FROM t_warehouse a 
                LEFT OUTER JOIN t_customer b ON a.fc_membercode = b.fc_membercode
            ) e ON d.fc_warehousecode = e.fc_warehousecode
            -- filter dari input user
            WHERE 
                (
                    (b.max_trans >= '$startTimestamp' AND '$startTimestamp' != '' AND '$startTimestamp' IS NOT NULL)
                    OR '$startTimestamp' = '' OR '$startTimestamp' IS NULL
                )
                AND (
                    (b.max_trans <= '$endTimestamp' AND '$endTimestamp' != '' AND '$endTimestamp' IS NOT NULL)
                    OR '$endTimestamp' = '' OR '$endTimestamp' IS NULL
                )
                AND (
                    (c.fc_warehousecode = '$warehouseFilter' AND '$warehouseFilter' != '' AND '$warehouseFilter' IS NOT NULL)
                    OR '$warehouseFilter' = '' OR '$warehouseFilter' IS NULL
                )
            ORDER BY a.fc_group, a.fc_namelong, c.created_at, d.fd_expired DESC"); 
    
        return Excel::download(new KartuStockExport($kartuStock, $range_date), $filename);
        // dd($endTimestamp);
    }
    

    public function generateQRCodePDF($fc_barcode, $count, $fd_expired_date, $fc_batch)
    {

        $fc_barcode_decode = base64_decode($fc_barcode);
        $count_decode = base64_decode($count);

        $qrcode = QrCode::size(250)->generate($fc_barcode_decode);

        // generate qrcode ke pdf
        $customPaper = array(0, 0, 300, 300);        
        $pdf = PDF::loadView(
            'pdf.qr-code2',
            [
                'qrcode' => $qrcode,
                'count' => $count_decode
            ]
        )->setPaper($customPaper);


        return $pdf->stream();
        // dd($kode_qr);
    }
}
