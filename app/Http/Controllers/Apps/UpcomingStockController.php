<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\PoDetail;
use Carbon\Carbon;
use DB;
use Validator;
use Auth;
use App\Helpers\ApiFormatter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UpcomingStockController extends Controller
{

    public function index()
    {
        return view('apps.upcoming-stock.index');
    }

    public function datatables(){
        $query = DB::table('db_dexa.t_podtl as a')
        ->select('a.fc_stockcode', DB::raw('SUM(a.fn_po_qty - a.fn_ro_qty) AS total_qty'), 'c.fc_namelong', 'c.fc_namepack')
        ->leftJoin('db_dexa.t_pomst as b', 'a.fc_pono', '=', 'b.fc_pono')
        ->leftJoin('db_dexa.t_stock as c', 'a.fc_stockcode', '=', 'c.fc_stockcode')
        ->where('b.fd_poexpired', '>=', DB::raw('SYSDATE()'))
        ->whereRaw('(a.fn_po_qty - a.fn_ro_qty) > 0')
        ->groupBy('a.fc_stockcode')
        ->orderBy('a.fc_stockcode');
        $data = $query->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_detail($fc_stockcode)
    {
        $decode_fc_stockcode = base64_decode($fc_stockcode);

        $query = DB::table('db_dexa.t_podtl as a')
            ->select(
                'a.fc_stockcode',
                'd.fc_namelong',
                'd.fc_namepack',
                DB::raw('(a.fn_po_qty - a.fn_ro_qty) AS QTY'),
                'a.fc_pono',
                'e.fc_suppliername1',
                DB::raw('b.fd_poexpired AS "kedatangan"')
            )
            ->leftJoin('db_dexa.t_pomst as b', 'a.fc_pono', '=', 'b.fc_pono')
            ->leftJoin('db_dexa.t_supplier as c', 'b.fc_suppliercode', '=', 'c.fc_suppliercode')
            ->leftJoin('db_dexa.t_stock as d', 'd.fc_stockcode', '=', 'a.fc_stockcode')
            ->leftJoin('db_dexa.t_supplier as e', 'b.fc_suppliercode', '=', 'e.fc_suppliercode')
            ->where('a.fc_stockcode', $decode_fc_stockcode) 
            ->where('b.fd_poexpired', '>=', DB::raw('SYSDATE()'))
            ->whereRaw('(a.fn_po_qty - a.fn_ro_qty) > 0');

        $data = $query->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->make(true);
    }
}
