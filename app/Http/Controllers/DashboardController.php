<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SoMaster;
use App\Models\PoMaster;
use App\Models\InvMaster;
use App\Models\Invstore;
use App\Models\NotificationMaster;
use Carbon\Carbon;
use DB;
use App\Models\NotificationDetail;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{

    public function index()
    {
        $userCount = User::all()->count();
        $soCount = SoMaster::all()->where('fc_branch', auth()->user()->fc_branch)->count();
        $poCount = PoMaster::all()->where('fc_branch', auth()->user()->fc_branch)->count();
        $invCount = InvMaster::all()->where('fc_branch', auth()->user()->fc_branch)->count(); 

        $expiredDateCount = Invstore::with('stock')
            ->where('t_invstore.fc_branch', auth()->user()->fc_branch)
            ->whereDate('t_invstore.fd_expired', '<=', now())
            ->where('fn_quantity', '>', 0)
            ->count();

            $subquery = DB::table('t_invstore')
                ->select(DB::raw('SUM(fn_quantity)'))
                ->where('fc_branch', auth()->user()->fc_branch);

            $maqCount = DB::table('t_invstore as a')
            ->select('a.fc_stockcode', DB::raw('SUM(a.fn_quantity) as total_quantity'), 'b.fn_maxonhand')
            ->leftJoin('t_stock as b', 'a.fc_stockcode', '=', 'b.fc_stockcode')
            ->groupBy('a.fc_stockcode')
            ->havingRaw('SUM(a.fn_quantity) > b.fn_maxonhand')
            ->count();


            $moqCount = DB::table('t_invstore as a')
                ->select('a.fc_stockcode', DB::raw('SUM(a.fn_quantity) as total_quantity'), 'b.fn_reorderlevel')
                ->leftJoin('t_stock as b', 'a.fc_stockcode', '=', 'b.fc_stockcode')
                ->groupBy('a.fc_stockcode')
                ->havingRaw('SUM(a.fn_quantity) < b.fn_reorderlevel')
                ->count();


       
        return view('dashboard.index', compact('userCount', 'soCount', 'poCount', 'invCount', 'expiredDateCount','moqCount','maqCount'));
        // dd($expiredDateCount);
        // dd($moqCount);
    }

    public function datatable($tipe){

        if ($tipe == 'expired') {
            $data = Invstore::with('stock')
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->whereDate('fd_expired', '<', now())
            ->where('fn_quantity', '>', 0)
            ->get();
        }else if($tipe == 'moq'){
            $data = Invstore::with('stock')
            ->join('t_stock', 't_invstore.fc_stockcode', '=', 't_stock.fc_stockcode')
            ->where('t_invstore.fc_branch', auth()->user()->fc_branch)
            ->groupBy('t_invstore.fc_stockcode')
            ->havingRaw('SUM(t_invstore.fn_quantity) < t_stock.fn_reorderlevel')
            ->get();
        }else{
            $data = Invstore::with('stock')
            ->join('t_stock', 't_invstore.fc_stockcode', '=', 't_stock.fc_stockcode')
            ->where('t_invstore.fc_branch', auth()->user()->fc_branch)
            ->groupBy('t_invstore.fc_stockcode')
            ->havingRaw('SUM(t_invstore.fn_quantity) > t_stock.fn_maxonhand')
            ->get();
        }
    
        // return datatables
        return DataTables::of($data )
            ->addIndexColumn()
            ->make();
    }



    public function view_all_notif(){
        return view('dashboard.view-all-notif');
    }

    public function search_menu(Request $request){
        // ambil user dan permissionnya dengan spatie
        $user = Auth::user();
        $permissions = $user->getAllPermissionsField($request);
        
        $filteredPermissions = $permissions->filter(function ($permission) use ($request) {
            return strpos($permission->name, $request->query('query')) !== false;
        });
        
        $filteredPermissions = $filteredPermissions->toArray();
    
        return [
            'status' => 200,
            'data' => array_values($filteredPermissions)
        ];
    }
}
