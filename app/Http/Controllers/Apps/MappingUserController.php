<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\MappingMaster;
use App\Models\MappingDetail;
use Carbon\Carbon;
use DB;
use Validator;
use App\Helpers\ApiFormatter;
use App\Models\MappingUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MappingUserController extends Controller
{

    public function index()
    {
        return view('apps.mapping-user.index');
    }

    public function datatables(){
        $data = MappingUser::with('mappingmst', 'user')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function detail($fc_mappingcode)
    {
        $mappingcode = base64_decode($fc_mappingcode);

        $data = MappingUser::with('user','mappingmst')
            ->where([
                'fc_mappingcode' =>  $mappingcode,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
            ])
            ->first();

        return ApiFormatter::getResponse($data);
    }

    public function get_user()
    {
        $data = User::where('fc_branch', auth()->user()->fc_branch)
        ->where('fl_hold','!=','T')
        ->get();

        if (empty($data)) {
            return [
                'status' => 200,
            ];
        }

        return ApiFormatter::getResponse($data);
    }

    public function get_mapping()
    {
        $data = MappingMaster::where('fc_branch', auth()->user()->fc_branch)->get();

        if (empty($data)) {
            return [
                'status' => 200,
            ];
        }

        return ApiFormatter::getResponse($data);
    }

    public function store_update(Request $request)
    {
        // validator
        $validator = Validator::make($request->all(), [
            'fc_userid' => 'required',
            'fc_mappingcode' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $mapping_user = MappingUser::where('fc_userid', $request->fc_userid)->where('fc_mappingcode', $request->fc_mappingcode)->where('fc_branch', auth()->user()->fc_branch)->first();

        if (empty($mapping_user)) {
            // create TempInvoiceMst
            $insert = MappingUser::create([
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_userid' => $request->fc_userid,
                'fc_mappingcode' => $request->fc_mappingcode,
                'fc_hold' => $request->fc_hold,
                'fv_description' => $request->fv_description,
            ]);

            if ($insert) {
                return [
                    'status' => 201,
                    'message' => 'Data berhasil disimpan',
                    'link' => '/apps/mapping-user'
                ];
            } else {
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];
            }
        } else {
            return [
                'status' => 300,
                'message' => 'Data sudah ada'
            ];
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            MappingUser::where('id', $id)->delete();

            DB::commit();

            return [
                'status' => 201, // SUCCESS
                'link' => '/apps/mapping-user',
                'message' => 'Data berhasil di Hapus'
            ];
        } catch (\Exception $e) {

            DB::rollback();

            return [
                'status'     => 300, // GAGAL
                'message'       => (env('APP_DEBUG', 'true') == 'true') ? $e->getMessage() : 'Operation error'
            ];
        }
    }
}
