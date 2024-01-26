<?php

namespace App\Http\Controllers\Apps;

use Auth;
use Carbon\Carbon;
use App\Models\KasBon;
use App\Helpers\Convert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables as DataTables;

class KasBonController extends Controller
{
    public function index()
    {
        $data = KasBon::all();

        return view('apps.kas-bon.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validation = [
            'fc_userapplicant' => 'required',
            'fd_kasbondate' => 'required',
            'fm_nominal' => 'required',
        ];

        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $division_code = Auth::user()->fc_divisioncode;
        $branch = Auth::user()->fc_branch;

        $create_kasbon = KasBon::create([
            'fc_userapplicant' => $request->fc_userapplicant,
            'fd_kasbondate' => $request->fd_kasbondate,
            'fv_description' => $request->fv_description,
            'fm_nominal' => Convert::convert_to_double($request->fm_nominal),
            'fc_status' => 'F',
            'fc_divisioncode' => $division_code,
            'fc_branch' => $branch,
            'created_by' => Auth::user()->fc_userid,
        ]);

        if ($create_kasbon) {
            return response()->json([
                'status' => 200,
                'message' => "Kas Bon Berhasil ditambahkan"
            ]);
        } else {
            return response()->json([
                'status' => 300,
                'message' => 'Kas Bon tidak berhasil ditambahkan'
            ]);
        }
    }

    public function update($kasbonno, Request $request)
    {
        $decode_kabonno = base64_decode($kasbonno);

        $KasBon = KasBon::where('fc_kasbonno', $decode_kabonno)->get();

        $message = $request->fc_status == 'J' ? 'Kas Bon berhasil dijurnal!' : 'Kas Bon berhasil dicancel!';

        $KasBon->toQuery()->update([
            'fc_status' => $request->fc_status,
            'updated_by' => Auth::user()->fc_userid,
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 200,
            'message' => $message,
        ]);
    }

    public function datatables()
    {
        $data = KasBon::orderBy('fc_kasbonno', 'asc')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
