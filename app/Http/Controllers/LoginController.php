<?php

namespace App\Http\Controllers;

use App\Models\InvMaster;
use App\Models\Invstore;
use App\Models\PoMaster;
use App\Models\SoMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Carbon;

use App\Models\User;
use DB;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $userCount = User::all()->count();
            $soCount = SoMaster::all()->where('fc_branch', auth()->user()->fc_branch)->count();
            $poCount = PoMaster::all()->where('fc_branch', auth()->user()->fc_branch)->count();
            $invCount = InvMaster::all()->where('fc_branch', auth()->user()->fc_branch)->count();

            $expiredDateCount = Invstore::with('stock')
                ->where('t_invstore.fc_branch', auth()->user()->fc_branch)
                ->whereDate('t_invstore.fd_expired', '<=', now())
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
            return view('dashboard.index', compact('userCount', 'soCount', 'poCount', 'invCount', 'maqCount', 'moqCount', 'expiredDateCount'));
            // dd($userCount, $soCount, $poCount, $invCount,$maqCount,$moqCount,$expiredDateCount);
        }

        return view('login.index');
    }

    public function login(Request $request)
    {
        $rules = [
            'userid' => 'required',
            'password' => 'required'
        ];

        $messages = [
            'userid.required' => 'Userid wajib di isi',
            'password.required' => 'Password wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
        

        $user = User::where(['fc_userid' => $request->userid])->first();
        if (!empty($user)) {
            if (Hash::check($request->password, $user->fc_password)) {

                if ($user->fl_hold == 'T') {
                    return [
                        'status' => 300,
                        'message' => 'Akun anda saat ini sedang di hold silahkan hubungi admin untuk aktivasi'
                    ];
                }

                if ($user->fd_expired != null && $user->fd_expired < Carbon::now()->format('Y-m-d')) {
                    return [
                        'status' => 300,
                        'message' => 'Akun anda saat ini sudah expired'
                    ];
                }

                Auth::login($user);
            }
        }

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            return [
                'status' => 201,
                'message' => 'Anda berhasil login',
                'link' => '/dashboard',
            ];
        } else {

            return [
                'status' => 300,
                'message' => 'Userid atau password anda salah silahkan coba lagi'
            ];
        }
    }

    public function change_password()
    {
        return view('login.change-password');
    }

    public function action_change_password(request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required| min:6',
            'retype_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $user = Auth::user();

        if (password_verify($request->old_password, $user->fc_password)) {
            $user->fc_password = Hash::make($request->new_password);
            $user->save();

            return [
                'status' => 200,
                'message' => 'Password berhasil diganti'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Password lama anda salah, silahkan coba lagi'
            ];
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}