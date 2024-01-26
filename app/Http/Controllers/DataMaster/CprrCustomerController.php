<?php

namespace App\Http\Controllers\DataMaster;

use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Convert;
use App\Helpers\NoDocument;
use App\Models\Cospertes;
use DataTables;
use Carbon\Carbon;
use File;

use App\Models\CprrCustomer;
use App\Models\Customer;
use DB;
use PHPUnit\Framework\Constraint\Count;

class CprrCustomerController extends Controller
{
    public function index()
    {
        return view('data-master.cprr-customer.index');
    }

    public function get($fc_cprrcode)
    {
        $data = Cospertes::where([
            'fc_cprrcode' => $fc_cprrcode,
        ])->where('fc_branch', auth()->user()->fc_branch)->first();
        return response($data, 200);
    }

    public function getAll()
    {
        $data = Cospertes::get();
        return ApiFormatter::getResponse($data);
    }

    public function detail($id)
    {
        $idCprrCustomer = base64_decode($id);
        
        $data = CprrCustomer::with('cospertes')->where([
            'id' => $idCprrCustomer,
        ])->first();
        
        return ApiFormatter::getResponse($data);
    }

    public function detailView($fc_membercode)
    {
        $membercode = base64_decode($fc_membercode);
        
        $data['data'] = Customer::with(
            'branch', 'member_type_business', 'member_typebranch',
            'member_legal_status', 'member_tax_code'
        )
        ->where('fc_branch', auth()->user()->fc_branch)
        ->where('fc_membercode', $membercode)
        ->first();

        // dd($data);
        return view('data-master.cprr-customer.detail',$data);
    }

    public function datatables_detail($fc_membercode)
    {
        $membercode = base64_decode($fc_membercode);
        
        $data = CprrCustomer::with('Cospertes')
        ->where('fc_branch', auth()->user()->fc_branch)
        ->where('fc_membercode',$membercode)
        ->get();

        return DataTables::of($data) 
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables()
    {
        $data = Customer::with('CprrCustomer.Cospertes','branch')
            ->withCount('CprrCustomer')
            ->has('CprrCustomer','>',0)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function store_update(request $request){
        $validator = Validator::make($request->all(), [
            'fc_membercode' => 'required',
            'fc_cprrcode' => 'required',
            'fm_price' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->request->add([
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode
        ]);

        if (empty($request->type)) {
            $cek_data = CprrCustomer::where([
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch,
                'fc_cprrcode' => $request->fc_cprrcode,
                'fc_membercode' => $request->fc_membercode,
                'deleted_at' => null,
            ])->withTrashed()->count();

            if ($cek_data > 0) {
                return [
                    'status' => 300,
                    'message' => 'Oops! Insert gagal karena data sudah ditemukan didalam sistem kami'
                ];
            }
        }

        $request->merge(['fm_price' => Convert::convert_to_double($request->fm_price)]);

        if ($request->has('fm_price') || $request->has('fv_description')) {
            $request->request->add(['updated_at' => Carbon::now()]);
        }

        if($request->type == 'update'){
            $data = CprrCustomer::where([
                'id' => $request->id,
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch,
                'fc_cprrcode' => $request->fc_cprrcode
            ])->first();
            // update
            $data->update($request->all());

            if($data){
                return [
                    'status' => 200,
                    'message' => 'Data berhasil diupdate'
                ];
            }else{
                return [
                    'status' => 300,
                    'message' => 'Oops! Terjadi kesalahan saat update data'
                ];
            }
        }else{
           $data = CprrCustomer::create([
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch,
                'fc_cprrcode' => $request->fc_cprrcode,
                'fc_membercode' => $request->fc_membercode,
                'fm_price' => $request->fm_price,
                'fv_description' => $request->fv_description,
            ], $request->all());
    
            if($data){
                return [
                    'status' => 200, // SUCCESS
                    'message' => 'Data berhasil disimpan'
                ];
            }else{
                return [
                    'status' => 300, // FAILED
                    'message' => 'Data gagal disimpan'
                ];
            }
           
        }
        // dd($request);
       
    }

    public function delete($id)
    {
        $idCprr = base64_decode($id);
        
        $delete = CprrCustomer::where([
            'id' => $idCprr
        ])->delete();

        if ($delete) {
            return response()->json([
                'status' => 200,
                'message' => "Data berhasil dihapus"
            ]);
        } else {
            return response()->json([
                'status' => 300,
                'message' => "Data gagal dihapus"
            ]);
        }
    }
}
