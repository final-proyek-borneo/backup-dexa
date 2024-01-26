<?php

namespace App\Http\Controllers\DataMaster;

use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Convert;
use App\Helpers\NoDocument;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\Cospertes;

class MasterCprrController extends Controller
{
    public function index()
    {
        return view('data-master.master-cprr.index');
    }

    public function edit(Request $request)
    {
        $data = Cospertes::where('fc_cprrcode', $request->fc_cprrcode)
            ->where('fc_branch', auth()->user()->fc_branch)->first();

        return response()->json([
            'status' => 200,
            'message' => 'Sukses',
            'data' => $data
        ]);
        dd($data);
    }

    public function datatables()
    {
        $data = Cospertes::with('branch','cprrCustomer')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function detail($id)
    {
        $idCprr = base64_decode($id);
        
        $data = Cospertes::where([
            'id' => $idCprr,
        ])->first();
        
        return ApiFormatter::getResponse($data);
    }

    public function store_update(request $request)
    {
        $validator = Validator::make($request->all(), [
            'fc_cprrcode' => 'required',
            'fc_cprrname' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->request->add(['fc_branch' => auth()->user()->fc_branch]);
        if (empty($request->type)) {
            $cek_data = Cospertes::where([
                'fc_cprrcode' => $request->fc_cprrcode,
                'fc_cprrname' => $request->fc_cprrname,
                'deleted_at' => null,
            ])->withTrashed()->count();

            if ($cek_data > 0) {
                return [
                    'status' => 300,
                    'message' => 'Oops! Insert gagal karena data sudah ditemukan didalam sistem kami'
                ];
            }
        }

        Cospertes::updateOrCreate([
            'fc_cprrcode' => $request->fc_cprrcode,
            'fc_cprrname' => $request->fc_cprrname,
        ], $request->all());

        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil disimpan'
        ];
    }

    public static function update(request $request)
    {
        Cospertes::with('branch')->where('fc_cprrcode', $request->fc_cprrcode)->update([
            'fc_cprrname' => $request->fc_cprrname,
            'fv_description' => $request->fv_description
        ]);
        
        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil di update'
        ];
    }

    public function delete($fc_cprrcode)
    {
        $delete = Cospertes::where([
            'fc_cprrcode' => $fc_cprrcode,
        ])->delete();

        if ($delete) {
            return response()->json([
                'status' => 200,
                'message' => "Data berhasil dihapus"
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => "Data gagal dihapus"
            ]);
        }
    }
}
