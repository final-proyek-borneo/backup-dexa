<?php

namespace App\Http\Controllers\Apps;

use App\Exports\SalesOrderExport;
use App\Exports\SalesOrderInMarketingExport;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;

use Yajra\DataTables\DataTables as DataTables;
use PDF;
use Carbon\Carbon;
use File;
use DB;

use App\Models\SoMaster;
use App\Models\SoDetail;
use App\Models\DoDetail;
use App\Models\Warehouse;
use App\Exports\WarehouseExport;
use App\Models\Sales;
use App\Models\SalesCustomer;
use App\Models\TempSoPay;
use Auth;
use Maatwebsite\Excel\Facades\Excel;

class MarketingController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }

    public function index()
    {
        if (is_null($this->user) || !$this->user->can('Marketing')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        }
        return view('apps.marketing.index');
    }

    public function persediaan()
    {
        if (is_null($this->user) || !$this->user->can('Master User')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        }
        return view('apps.marketing.persediaan-index');
    }

    public function detail($fc_warehousecode)
    {
        $fc_warehousecode = base64_decode($fc_warehousecode);
        $data['gudang_mst'] = Warehouse::where('fc_warehousecode', $fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->first();
        return view('apps.marketing.persediaan-detail', $data);
        // dd($data);
    }

    public function export_rekap(Request $request)
    {
        ini_set('memory_limit', '2048M'); // 2GB
        set_time_limit(360);
        $decode_fc_warehousecode = base64_decode($request->fc_warehousecode);
        return Excel::download(new WarehouseExport($decode_fc_warehousecode), 'rekap_persediaan_barang.xlsx');
    }

    // kalau butuh datatable dengan filter cukup pilih salah satu sales, customer
    public function datatable_preview(Request $request)
    {
        $datacode = $request->fc_membercode == '' ? $request->fc_membercode2 : '';

        if ($request->fc_type == 'CUSTOMER') {
            $query = DB::table('db_dexa.t_sodtl as a')
                ->select(
                    'c.fc_divisioncode',
                    'b.fc_salescode',
                    DB::raw("CONCAT(d.fc_salesname1, ' [', d.fn_saleslevel, '] ') as sales_profile"),
                    'b.fc_membercode',
                    DB::raw("CONCAT(c.fc_membername1, ' ', COALESCE(c.fc_membername2, '')) as membername"),
                    DB::raw("CONCAT(COALESCE(c.fc_memberaddress1, ''), ' ', COALESCE(c.fc_memberaddress2, '')) as memberaddress"),
                    'c.fc_membertypebusiness',
                    'c.fc_member_branchtype',
                    'b.fc_sotype',
                    'b.fd_sodatesysinput',
                    'b.fd_soexpired',
                    'a.fc_sono',
                    'fn_sodetail',
                    DB::raw("CASE 
                            WHEN b.fc_sostatus = 'CC' THEN 'SO CANCELED'
                            WHEN b.fc_sostatus = 'C' THEN 'SO FINISHED, CHECK CUSTOMER PAYMENT'
                            WHEN b.fc_sostatus = 'F' THEN 'COMPLETED APPROVAL, WAITING DO'
                            WHEN b.fc_sostatus = 'P' THEN 'SO STILL PENDING OR PARTIALY INPUT'
                            WHEN b.fc_sostatus = 'CL' THEN 'SO CLOSED'
                            WHEN b.fc_sostatus = 'DD' THEN 'ALL ITEM HAVE BEEN PROCESSED FOR DELIVERY AND WAITING FOR INVOICING'
                            WHEN b.fc_sostatus = 'WA' THEN 'SO IS WAITING FOR APPROVAL'
                            WHEN b.fc_sostatus = 'C' THEN 'SO IS WAITING FOR APPROVAL'
                         END as status_so"),
                    'a.fn_sorownum',
                    'a.fc_stockcode',
                    'x.fc_namelong',
                    'a.fn_so_qty',
                    'a.fm_so_price',
                    'a.fn_so_value',
                    'a.fn_do_qty',
                    DB::raw("(a.fn_so_qty - a.fn_do_qty) as qty_kurang_kirim"),
                    DB::raw("CASE 
                            WHEN (a.fn_so_qty > a.fn_do_qty) AND (a.fn_do_qty > 0) THEN 'item waiting for completion'
                            WHEN (a.fn_so_qty > a.fn_do_qty) AND (a.fn_do_qty = 0) THEN 'no progress item'
                         END as status_qty")
                )
                ->leftJoin('db_dexa.t_stock as x', 'a.fc_stockcode', '=', 'x.fc_stockcode')
                ->leftJoin('db_dexa.t_somst as b', 'a.fc_sono', '=', 'b.fc_sono')
                ->leftJoin('db_dexa.t_customer as c', 'b.fc_membercode', '=', 'c.fc_membercode')
                ->leftJoin('db_dexa.t_sales as d', 'b.fc_salescode', '=', 'd.fc_salescode')
                ->where('b.fd_sodatesysinput', '>=', $request->fd_sodatesysinput_start)
                ->where('b.fd_sodatesysinput', '<=', $request->fd_sodatesysinput_end)
                ->where('b.fc_sostatus', '=', 'P')
                ->where('a.fn_so_qty', '>', DB::raw('a.fn_do_qty'))
                // ->where('b.fc_membercode', '=', 'CUST2023A001SBY0010000096')
                ->where('b.fc_membercode', '=', $datacode)
                ->orderBy('b.fc_membercode')
                ->orderBy('b.fc_sotype')
                ->orderBy('b.fc_sono')
                ->orderBy('a.fn_sorownum');
            $result = $query->get();

            // taruh dan atur view pdf disini
        } else if ($request->fc_type == 'SALES') {
            // dd($request->fc_salescode);
            $query = DB::table('db_dexa.t_sodtl as a')
                ->select(
                    'c.fc_divisioncode',
                    'b.fc_salescode',
                    DB::raw("CONCAT(d.fc_salesname1, ' [', d.fn_saleslevel, '] ') as sales_profile"),
                    'b.fc_membercode',
                    DB::raw("CONCAT(c.fc_membername1, ' ', COALESCE(c.fc_membername2, '')) as membername"),
                    DB::raw("CONCAT(COALESCE(c.fc_memberaddress1, ''), ' ', COALESCE(c.fc_memberaddress2, '')) as memberaddress"),
                    'c.fc_membertypebusiness',
                    'c.fc_member_branchtype',
                    'b.fc_sotype',
                    'b.fd_sodatesysinput',
                    'b.fd_soexpired',
                    'a.fc_sono',
                    'fn_sodetail',
                    DB::raw("CASE 
                            WHEN b.fc_sostatus = 'CC' THEN 'SO CANCELED'
                            WHEN b.fc_sostatus = 'C' THEN 'SO FINISHED, CHECK CUSTOMER PAYMENT'
                            WHEN b.fc_sostatus = 'F' THEN 'COMPLETED APPROVAL, WAITING DO'
                            WHEN b.fc_sostatus = 'P' THEN 'SO STILL PENDING OR PARTIALY INPUT'
                            WHEN b.fc_sostatus = 'CL' THEN 'SO CLOSED'
                            WHEN b.fc_sostatus = 'DD' THEN 'ALL ITEM HAVE BEEN PROCESSED FOR DELIVERY AND WAITING FOR INVOICING'
                            WHEN b.fc_sostatus = 'WA' THEN 'SO IS WAITING FOR APPROVAL'
                            WHEN b.fc_sostatus = 'C' THEN 'SO IS WAITING FOR APPROVAL'
                         END as status_so"),
                    'a.fn_sorownum',
                    'a.fc_stockcode',
                    'x.fc_namelong',
                    'a.fn_so_qty',
                    'a.fm_so_price',
                    'a.fn_so_value',
                    'a.fn_do_qty',
                    DB::raw("(a.fn_so_qty - a.fn_do_qty) as qty_kurang_kirim"),
                    DB::raw("CASE 
                            WHEN (a.fn_so_qty > a.fn_do_qty) AND (a.fn_do_qty > 0) THEN 'item waiting for completion'
                            WHEN (a.fn_so_qty > a.fn_do_qty) AND (a.fn_do_qty = 0) THEN 'no progress item'
                         END as status_qty")
                )
                ->leftJoin('db_dexa.t_stock as x', 'a.fc_stockcode', '=', 'x.fc_stockcode')
                ->leftJoin('db_dexa.t_somst as b', 'a.fc_sono', '=', 'b.fc_sono')
                ->leftJoin('db_dexa.t_customer as c', 'b.fc_membercode', '=', 'c.fc_membercode')
                ->leftJoin('db_dexa.t_sales as d', 'b.fc_salescode', '=', 'd.fc_salescode')
                ->where('b.fd_sodatesysinput', '>=', $request->fd_sodatesysinput_start)
                ->where('b.fd_sodatesysinput', '<=', $request->fd_sodatesysinput_end)
                ->where('b.fc_sostatus', '=', 'P')
                ->where('a.fn_so_qty', '>', DB::raw('a.fn_do_qty'))
                // ->where('b.fc_salescode', '=', 'SALS20230055')
                // ->where('b.fc_salescode', '=', $datacode)
                ->where('b.fc_membercode', '=', $datacode)
                ->orderBy('b.fc_membercode')
                ->orderBy('b.fc_sotype')
                ->orderBy('b.fc_sono')
                ->orderBy('a.fn_sorownum');
            $result = $query->get();

            // taruh dan atur view pdf disini
        } else if ($request->fc_type == 'STATUS') {

            $query = DB::table('db_dexa.t_sodtl as a')
                ->select(
                    'c.fc_divisioncode',
                    'b.fc_salescode',
                    DB::raw("CONCAT(d.fc_salesname1, ' [', d.fn_saleslevel, '] ') as sales_profile"),
                    'b.fc_membercode',
                    DB::raw("CONCAT(c.fc_membername1, ' ', COALESCE(c.fc_membername2, '')) as membername"),
                    DB::raw("CONCAT(COALESCE(c.fc_memberaddress1, ''), ' ', COALESCE(c.fc_memberaddress2, '')) as memberaddress"),
                    'c.fc_membertypebusiness',
                    'c.fc_member_branchtype',
                    'b.fc_sotype',
                    'b.fd_sodatesysinput',
                    'b.fd_soexpired',
                    'a.fc_sono',
                    'fn_sodetail',
                    DB::raw("CASE 
                                    WHEN b.fc_sostatus = 'CC' THEN 'SO CANCELED'
                                    WHEN b.fc_sostatus = 'C' THEN 'SO FINISHED, CHECK CUSTOMER PAYMENT'
                                    WHEN b.fc_sostatus = 'F' THEN 'COMPLETED APPROVAL, WAITING DO'
                                    WHEN b.fc_sostatus = 'P' THEN 'SO STILL PENDING OR PARTIALY INPUT'
                                    WHEN b.fc_sostatus = 'CL' THEN 'SO CLOSED'
                                    WHEN b.fc_sostatus = 'DD' THEN 'ALL ITEM HAVE BEEN PROCESSED FOR DELIVERY AND WAITING FOR INVOICING'
                                    WHEN b.fc_sostatus = 'WA' THEN 'SO IS WAITING FOR APPROVAL'
                                    WHEN b.fc_sostatus = 'C' THEN 'SO IS WAITING FOR APPROVAL'
                                END as status_so"),
                    'a.fn_sorownum',
                    'a.fc_stockcode',
                    'x.fc_namelong',
                    'a.fn_so_qty',
                    'a.fm_so_price',
                    'a.fn_so_value',
                    'a.fn_do_qty',
                    DB::raw("(a.fn_so_qty - a.fn_do_qty) as qty_kurang_kirim"),
                    DB::raw("CASE 
                                    WHEN (a.fn_so_qty > a.fn_do_qty) AND (a.fn_do_qty > 0) THEN 'item waiting for completion'
                                    WHEN (a.fn_so_qty > a.fn_do_qty) AND (a.fn_do_qty = 0) THEN 'no progress item'
                                END as status_qty")
                )
                ->leftJoin('db_dexa.t_stock as x', 'a.fc_stockcode', '=', 'x.fc_stockcode')
                ->leftJoin('db_dexa.t_somst as b', 'a.fc_sono', '=', 'b.fc_sono')
                ->leftJoin('db_dexa.t_customer as c', 'b.fc_membercode', '=', 'c.fc_membercode')
                ->leftJoin('db_dexa.t_sales as d', 'b.fc_salescode', '=', 'd.fc_salescode')
                ->where('b.fd_sodatesysinput', '>=', $request->fd_sodatesysinput_start)
                ->where('b.fd_sodatesysinput', '<=', $request->fd_sodatesysinput_end)
                ->where('b.fc_sostatus', '=', 'P')
                ->where('b.fc_membercode', '=', $datacode);
            if ($request->fc_status == 'BT') {
                $query->where('a.fn_do_qty', '=', 0)
                    ->orderBy('b.fc_membercode')
                    ->orderBy('b.fc_sotype')
                    ->orderBy('b.fc_sono')
                    ->orderBy('a.fn_sorownum');
                $result = $query->get();
            } else if ($request->fc_status == 'P') {
                $query->where('a.fn_so_qty', '>', DB::raw('a.fn_do_qty'))
                    ->where('a.fn_do_qty', '!=', 0)
                    ->orderBy('b.fc_membercode')
                    ->orderBy('b.fc_sotype')
                    ->orderBy('b.fc_sono')
                    ->orderBy('a.fn_sorownum');
                $result = $query->get();
            } else if ($request->fc_status == 'F') {
                $query->where('a.fn_so_qty', '=', DB::raw('a.fn_do_qty'))
                    ->orderBy('b.fc_membercode')
                    ->orderBy('b.fc_sotype')
                    ->orderBy('b.fc_sono')
                    ->orderBy('a.fn_sorownum');
                $result = $query->get();
            } else {
                $query->orderBy('b.fc_membercode')
                    ->orderBy('b.fc_sotype')
                    ->orderBy('b.fc_sono')
                    ->orderBy('a.fn_sorownum');
                $result = $query->get();
            }
        }

        return DataTables::of($result)
            ->addIndexColumn()
            ->make(true);
        // dd($request->all());
    }

    public function get_role_sales($fc_salescode)
    {
        $decode_fc_salescode = base64_decode($fc_salescode);
        // jika ada atau exist fc_salescode sama dengan $decode_fc_salescode
        $cek_salescode = Sales::where('fc_salescode', $decode_fc_salescode)->exists();
        if ($cek_salescode) {
            return response()->json([
                'status' => 200,
                'data' => $decode_fc_salescode,
                'role' => 'sales'
            ]);
        } else {
            return response()->json([
                'status' => 204,
            ]);
        }
    }

    // buat pilih filter customer by sales
    public function get_customer_by_sales()
    {
        $salesCode = auth()->user()->fc_userid;
        $data = SalesCustomer::with(
            'customer',
            'sales'
        )->where('fc_salescode', $salesCode)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    public function datatables_sales_customer($fc_salescode)
    {
        $decoded_fc_salescode = base64_decode($fc_salescode);
        $data = SalesCustomer::with(
            'customer',
            'sales'
        )->where('fc_salescode', $decoded_fc_salescode)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_customer($fc_salescode)
    {
        $decoded_fc_salescode = base64_decode($fc_salescode);
        $data = SalesCustomer::with(
            'customer',
            'sales'
        )->where('fc_salescode', $decoded_fc_salescode)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    // untuk export data ke pdf
    public function export_pdf(Request $request)
    {
        // jika $request->fc_membercode string kosong
        $datacode = $request->fc_membercode == '' ? $request->fc_membercode2 : '';

        if ($request->fc_type == 'CUSTOMER') {
            $query = DB::table('db_dexa.t_sodtl as a')
                ->select(
                    'c.fc_divisioncode',
                    'b.fc_salescode',
                    DB::raw("CONCAT(d.fc_salesname1, ' [', d.fn_saleslevel, '] ') as sales_profile"),
                    'b.fc_membercode',
                    DB::raw("CONCAT(c.fc_membername1, ' ', COALESCE(c.fc_membername2, '')) as membername"),
                    DB::raw("CONCAT(COALESCE(c.fc_memberaddress1, ''), ' ', COALESCE(c.fc_memberaddress2, '')) as memberaddress"),
                    'c.fc_membertypebusiness',
                    'c.fc_member_branchtype',
                    'b.fc_sotype',
                    'b.fd_sodatesysinput',
                    'b.fd_soexpired',
                    'a.fc_sono',
                    'fn_sodetail',
                    DB::raw("CASE 
                            WHEN b.fc_sostatus = 'CC' THEN 'SO CANCELED'
                            WHEN b.fc_sostatus = 'C' THEN 'SO FINISHED, CHECK CUSTOMER PAYMENT'
                            WHEN b.fc_sostatus = 'F' THEN 'COMPLETED APPROVAL, WAITING DO'
                            WHEN b.fc_sostatus = 'P' THEN 'SO STILL PENDING OR PARTIALY INPUT'
                            WHEN b.fc_sostatus = 'CL' THEN 'SO CLOSED'
                            WHEN b.fc_sostatus = 'DD' THEN 'ALL ITEM HAVE BEEN PROCESSED FOR DELIVERY AND WAITING FOR INVOICING'
                            WHEN b.fc_sostatus = 'WA' THEN 'SO IS WAITING FOR APPROVAL'
                            WHEN b.fc_sostatus = 'C' THEN 'SO IS WAITING FOR APPROVAL'
                         END as status_so"),
                    'a.fn_sorownum',
                    'a.fc_stockcode',
                    'x.fc_namelong',
                    'a.fn_so_qty',
                    'a.fm_so_price',
                    'a.fn_so_value',
                    'a.fn_do_qty',
                    DB::raw("(a.fn_so_qty - a.fn_do_qty) as qty_kurang_kirim"),
                    DB::raw("CASE 
                            WHEN (a.fn_so_qty > a.fn_do_qty) AND (a.fn_do_qty > 0) THEN 'item waiting for completion'
                            WHEN (a.fn_so_qty > a.fn_do_qty) AND (a.fn_do_qty = 0) THEN 'no progress item'
                         END as status_qty")
                )
                ->leftJoin('db_dexa.t_stock as x', 'a.fc_stockcode', '=', 'x.fc_stockcode')
                ->leftJoin('db_dexa.t_somst as b', 'a.fc_sono', '=', 'b.fc_sono')
                ->leftJoin('db_dexa.t_customer as c', 'b.fc_membercode', '=', 'c.fc_membercode')
                ->leftJoin('db_dexa.t_sales as d', 'b.fc_salescode', '=', 'd.fc_salescode')
                ->where('b.fd_sodatesysinput', '>=', $request->fd_sodatesysinput_start)
                ->where('b.fd_sodatesysinput', '<=', $request->fd_sodatesysinput_end)
                ->where('b.fc_sostatus', '=', 'P')
                ->where('a.fn_so_qty', '>', DB::raw('a.fn_do_qty'))
                // ->where('b.fc_membercode', '=', 'CUST2023A001SBY0010000096')
                ->where('b.fc_membercode', '=', $datacode)
                ->orderBy('b.fc_membercode')
                ->orderBy('b.fc_sotype')
                ->orderBy('b.fc_sono')
                ->orderBy('a.fn_sorownum');
            $result = $query->get();

            // taruh dan atur view pdf disini
        } else if ($request->fc_type == 'SALES') {
            // dd($request->fc_salescode);
            $query = DB::table('db_dexa.t_sodtl as a')
                ->select(
                    'c.fc_divisioncode',
                    'b.fc_salescode',
                    DB::raw("CONCAT(d.fc_salesname1, ' [', d.fn_saleslevel, '] ') as sales_profile"),
                    'b.fc_membercode',
                    DB::raw("CONCAT(c.fc_membername1, ' ', COALESCE(c.fc_membername2, '')) as membername"),
                    DB::raw("CONCAT(COALESCE(c.fc_memberaddress1, ''), ' ', COALESCE(c.fc_memberaddress2, '')) as memberaddress"),
                    'c.fc_membertypebusiness',
                    'c.fc_member_branchtype',
                    'b.fc_sotype',
                    'b.fd_sodatesysinput',
                    'b.fd_soexpired',
                    'a.fc_sono',
                    'fn_sodetail',
                    DB::raw("CASE 
                            WHEN b.fc_sostatus = 'CC' THEN 'SO CANCELED'
                            WHEN b.fc_sostatus = 'C' THEN 'SO FINISHED, CHECK CUSTOMER PAYMENT'
                            WHEN b.fc_sostatus = 'F' THEN 'COMPLETED APPROVAL, WAITING DO'
                            WHEN b.fc_sostatus = 'P' THEN 'SO STILL PENDING OR PARTIALY INPUT'
                            WHEN b.fc_sostatus = 'CL' THEN 'SO CLOSED'
                            WHEN b.fc_sostatus = 'DD' THEN 'ALL ITEM HAVE BEEN PROCESSED FOR DELIVERY AND WAITING FOR INVOICING'
                            WHEN b.fc_sostatus = 'WA' THEN 'SO IS WAITING FOR APPROVAL'
                            WHEN b.fc_sostatus = 'C' THEN 'SO IS WAITING FOR APPROVAL'
                         END as status_so"),
                    'a.fn_sorownum',
                    'a.fc_stockcode',
                    'x.fc_namelong',
                    'a.fn_so_qty',
                    'a.fm_so_price',
                    'a.fn_so_value',
                    'a.fn_do_qty',
                    DB::raw("(a.fn_so_qty - a.fn_do_qty) as qty_kurang_kirim"),
                    DB::raw("CASE 
                            WHEN (a.fn_so_qty > a.fn_do_qty) AND (a.fn_do_qty > 0) THEN 'item waiting for completion'
                            WHEN (a.fn_so_qty > a.fn_do_qty) AND (a.fn_do_qty = 0) THEN 'no progress item'
                         END as status_qty")
                )
                ->leftJoin('db_dexa.t_stock as x', 'a.fc_stockcode', '=', 'x.fc_stockcode')
                ->leftJoin('db_dexa.t_somst as b', 'a.fc_sono', '=', 'b.fc_sono')
                ->leftJoin('db_dexa.t_customer as c', 'b.fc_membercode', '=', 'c.fc_membercode')
                ->leftJoin('db_dexa.t_sales as d', 'b.fc_salescode', '=', 'd.fc_salescode')
                ->where('b.fd_sodatesysinput', '>=', $request->fd_sodatesysinput_start)
                ->where('b.fd_sodatesysinput', '<=', $request->fd_sodatesysinput_end)
                ->where('b.fc_sostatus', '=', 'P')
                ->where('a.fn_so_qty', '>', DB::raw('a.fn_do_qty'))
                // ->where('b.fc_salescode', '=', 'SALS20230055')
                // ->where('b.fc_salescode', '=', $datacode)
                ->where('b.fc_membercode', '=', $datacode)
                ->orderBy('b.fc_membercode')
                ->orderBy('b.fc_sotype')
                ->orderBy('b.fc_sono')
                ->orderBy('a.fn_sorownum');
            $result = $query->get();

            // taruh dan atur view pdf disini
        } else if ($request->fc_type == 'STATUS') {

            $query = DB::table('db_dexa.t_sodtl as a')
                ->select(
                    'c.fc_divisioncode',
                    'b.fc_salescode',
                    DB::raw("CONCAT(d.fc_salesname1, ' [', d.fn_saleslevel, '] ') as sales_profile"),
                    'b.fc_membercode',
                    DB::raw("CONCAT(c.fc_membername1, ' ', COALESCE(c.fc_membername2, '')) as membername"),
                    DB::raw("CONCAT(COALESCE(c.fc_memberaddress1, ''), ' ', COALESCE(c.fc_memberaddress2, '')) as memberaddress"),
                    'c.fc_membertypebusiness',
                    'c.fc_member_branchtype',
                    'b.fc_sotype',
                    'b.fd_sodatesysinput',
                    'b.fd_soexpired',
                    'a.fc_sono',
                    'fn_sodetail',
                    DB::raw("CASE 
                                    WHEN b.fc_sostatus = 'CC' THEN 'SO CANCELED'
                                    WHEN b.fc_sostatus = 'C' THEN 'SO FINISHED, CHECK CUSTOMER PAYMENT'
                                    WHEN b.fc_sostatus = 'F' THEN 'COMPLETED APPROVAL, WAITING DO'
                                    WHEN b.fc_sostatus = 'P' THEN 'SO STILL PENDING OR PARTIALY INPUT'
                                    WHEN b.fc_sostatus = 'CL' THEN 'SO CLOSED'
                                    WHEN b.fc_sostatus = 'DD' THEN 'ALL ITEM HAVE BEEN PROCESSED FOR DELIVERY AND WAITING FOR INVOICING'
                                    WHEN b.fc_sostatus = 'WA' THEN 'SO IS WAITING FOR APPROVAL'
                                    WHEN b.fc_sostatus = 'C' THEN 'SO IS WAITING FOR APPROVAL'
                                END as status_so"),
                    'a.fn_sorownum',
                    'a.fc_stockcode',
                    'x.fc_namelong',
                    'a.fn_so_qty',
                    'a.fm_so_price',
                    'a.fn_so_value',
                    'a.fn_do_qty',
                    DB::raw("(a.fn_so_qty - a.fn_do_qty) as qty_kurang_kirim"),
                    DB::raw("CASE 
                                    WHEN (a.fn_so_qty > a.fn_do_qty) AND (a.fn_do_qty > 0) THEN 'item waiting for completion'
                                    WHEN (a.fn_so_qty > a.fn_do_qty) AND (a.fn_do_qty = 0) THEN 'no progress item'
                                END as status_qty")
                )
                ->leftJoin('db_dexa.t_stock as x', 'a.fc_stockcode', '=', 'x.fc_stockcode')
                ->leftJoin('db_dexa.t_somst as b', 'a.fc_sono', '=', 'b.fc_sono')
                ->leftJoin('db_dexa.t_customer as c', 'b.fc_membercode', '=', 'c.fc_membercode')
                ->leftJoin('db_dexa.t_sales as d', 'b.fc_salescode', '=', 'd.fc_salescode')
                ->where('b.fd_sodatesysinput', '>=', $request->fd_sodatesysinput_start)
                ->where('b.fd_sodatesysinput', '<=', $request->fd_sodatesysinput_end)
                ->where('b.fc_sostatus', '=', 'P')
                ->where('b.fc_membercode', '=', $datacode);
            if ($request->fc_status == 'BT') {
                $query->where('a.fn_do_qty', '=', 0)
                    ->orderBy('b.fc_membercode')
                    ->orderBy('b.fc_sotype')
                    ->orderBy('b.fc_sono')
                    ->orderBy('a.fn_sorownum');
                $result = $query->get();
            } else if ($request->fc_status == 'P') {
                $query->where('a.fn_so_qty', '>', DB::raw('a.fn_do_qty'))
                    ->where('a.fn_do_qty', '!=', 0)
                    ->orderBy('b.fc_membercode')
                    ->orderBy('b.fc_sotype')
                    ->orderBy('b.fc_sono')
                    ->orderBy('a.fn_sorownum');
                $result = $query->get();
            } else if ($request->fc_status == 'F') {
                $query->where('a.fn_so_qty', '=', DB::raw('a.fn_do_qty'))
                    ->orderBy('b.fc_membercode')
                    ->orderBy('b.fc_sotype')
                    ->orderBy('b.fc_sono')
                    ->orderBy('a.fn_sorownum');
                $result = $query->get();
            } else {
                $query->orderBy('b.fc_membercode')
                    ->orderBy('b.fc_sotype')
                    ->orderBy('b.fc_sono')
                    ->orderBy('a.fn_sorownum');
                $result = $query->get();
            }
        }

        $data['data'] = $result;
        $data['fc_type'] = $request->fc_type;
        $data['fc_status'] = $request->fc_status;
        $data['fc_salescode'] = $request->fc_salescode;
        $data['fc_membercode'] = $request->fc_membercode;
        $data['fd_sodatesysinput_start'] = $request->fd_sodatesysinput_start;
        $data['fd_sodatesysinput_end'] = $request->fd_sodatesysinput_end;
        if ($request->fc_type == 'CUSTOMER') {
            $data['membername'] = $result[0]->membername ?? '-';
            $data['sales_profile'] = $result[0]->sales_profile ?? '-';
        }
        if ($request->fc_type == 'SALES' || $request->fc_type == 'CUSTOMER') {
            $data['sales_profile'] = $result[0]->sales_profile ?? '-';
            $data['membername'] = $result[0]->membername ?? '-';
        }

        if ($request->fc_type == 'STATUS') {
            $data['sales_profile'] = $result[0]->sales_profile ?? '-';
            $data['membername'] = $result[0]->membername ?? '-';
        }

        $pdf = PDF::loadView('pdf.report-marketing', $data)->setPaper('a4');
        return $pdf->stream();

        // dd($request->all());
    }

    public function export_excel(Request $request)
    {
        if ($request->fc_type == 'STATUS') {
            return Excel::download(new SalesOrderInMarketingExport($request), 'Sales_Order_Report_By_Status.xlsx');
        } else if ($request->fc_type == 'CUSTOMER') {
            return Excel::download(new SalesOrderInMarketingExport($request), 'Sales_Order_Report_By_Customer.xlsx');
        } else if ($request->fc_type == 'SALES') {
            return Excel::download(new SalesOrderInMarketingExport($request), 'Sales_Order_Report_By_Sales.xlsx');
        } else {
            return Excel::download(new SalesOrderInMarketingExport($request), 'Sales_Order_Report.xlsx');
        }
        // return Excel::download(new SalesOrderInMarketingExport(), 'sales_order_report.xlsx');
        // dd($request->all());
    }
}
