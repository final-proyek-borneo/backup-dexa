<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\Brand;

class MasterBrandController extends Controller
{
    public function index(){
        return view('data-master.master-brand.index');
    }

    public function detail($id){
        return Brand::where([
            'id' => $id,
        ])->first();
    }

    public function datatables(){
        $data = Brand::with('branch')->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
       $validator = Validator::make($request->all(), [
            'fc_divisioncode' => 'required',
            'fc_brand' => 'required',
            'fc_group' => 'required',
            'fc_subgroup' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->request->add(['fc_branch' => auth()->user()->fc_branch]);
        if(empty($request->type)){
            $cek_data = Brand::where([
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch,
                'fc_brand' => $request->fc_brand,
                'fc_group' => $request->fc_group,
                'fc_subgroup' => $request->fc_subgroup,
                'deleted_at' => null,
            ])->withTrashed()->count();

            if($cek_data > 0){
                return [
                    'status' => 300,
                    'message' => 'Oops! Insert gagal karena data sudah ditemukan didalam sistem kami'
                ];
            }else{
                $insert = Brand::create([
                    'fc_divisioncode' => $request->fc_divisioncode,
                    'fc_branch' => $request->fc_branch,
                    'fc_brand' => $request->fc_brand,
                    'fc_group' => $request->fc_group,
                    'fc_subgroup' => $request->fc_subgroup,
                ], $request->all());

                if($insert){
                    return [
                        'status' => 200,
                        'message' => 'Success! Data berhasil disimpan'
                    ];
                }else{
                    return [
                        'status' => 300,
                        'message' => 'Oops! Terjadi kesalahan saat menyimpan data'
                    ];
                }
            }
        } else{
            $updateBrand = Brand::updateOrCreate([
                'id' => $request->id,
            ], $request->all());
            
            if($updateBrand){
                return [
                    'status' => 200, // SUCCESS
                    'message' => 'Data berhasil diupdate'
                ];
            } else {
                return [
                    'status' => 300,
                    'message' => 'Oops! Terjadi kesalahan saat mengupdate data'
                ];
            }
        }


        
    }

    public function delete($id){
        Brand::where([
            'id' => $id,
        ])->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }
}
