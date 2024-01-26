<?php

namespace App\Http\Controllers\DataMaster;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Cospertes;
use App\Models\MasterCoa;
use Illuminate\Http\Request;
use Validator;
use DataTables;
use DB;

class MasterCoaController extends Controller
{
    public function index()
    {
        set_time_limit(360);
        $deepestLayer = MasterCoa::select('fn_layer')->orderBy('fn_layer','DESC')->first();
        
        $stringRelasi = 'children';
        for($i = 1; $i <  $deepestLayer->fn_layer; $i++){
            $stringRelasi .= '.children';
        }

        $coacode = MasterCoa::with('parent', $stringRelasi)
        ->where([
            'fn_layer' =>  0,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
        ])->get();

        $formattedData = $this->rekurAccordion($coacode);
        
        return view('data-master.master-coa.index', ['formattedData' => $formattedData]);
        // return ApiFormatter::getResponse($coacode);
    }

    private function rekurAccordion($coaItems, $level = 0){
        $html = '';
        // looping sebanyak data
        foreach ($coaItems as $item) {
            $subItems = $item->children;
    
            // kode html view
            $html .= '<div class="accordion">';
            $html .= '<div class="accordion-header collapsed d-flex justify-content-between" role="button" data-toggle="collapse" data-target="#panel-body-' . $item->id . '" aria-expanded="false">';
            $html .= '<h4>' . $item->fc_coacode . ' [' . $item->fc_coaname . ']</h4>';
            $html .= '<h4>Rp. ' . number_format($item->fm_balance,2,',','.') . '</h4>';
            $html .= '</div>';
            $html .= '<div class="accordion-body collapse" id="panel-body-' . $item->id . '" data-parent="#accordion' . $level . '">';
            $html .= '<div class="d-flex justify-content-between mb-2">';
            $html .= '<p>' . $item->fv_description . '</p>';
            $html .= '<div class="d-flex justify-content-between mb-2">';
            $html .= '<button type="button" class="btn btn-sm btn-warning mr-2" onclick="edit(\'' . $item->fc_coacode . '\');"><i class="fas fa-edit"></i> Edit</button>';
            $html .= '<button type="button" class="btn btn-sm btn-success" onclick="add_child(' . $item->fn_layer + 1 .', \'' . $item->fc_coacode . '\', \'' . $item->fc_coaname . '\');"><i class="fa fa-plus"></i> Tambah Child COA</button>';
            $html .= '</div>';
            $html .= '</div>';
            
            // apabila terdapat children
            if ($subItems->count() > 0) {
                $html .= '<div id="accordion' . ($level + 1) . '">';
                // tampilkan apabila terdapat children dengan rekursif
                $html .= $this->rekurAccordion($subItems, $level + 1);
                $html .= '</div>';
            }
    
            $html .= '</div>';
            $html .= '</div>';
        }
        return $html;
    }

    public function detail($fc_coacode)
    {
        $coacode = base64_decode($fc_coacode);

        $data = MasterCoa::with('branch','parent', 'transaksitype')
            ->where([
                'fc_coacode' =>  $coacode,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
            ])
            ->first();

        return ApiFormatter::getResponse($data);
    }

    public function datatables()
    {
        $data = MasterCoa::with('branch', 'parent')->where([
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_rootstatus' => 'F'
        ])->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_coa_mapping()
    {
        $data = MasterCoa::with('branch', 'parent')->where([
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_rootstatus' => 'T'
        ])->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function getParent($layer)
    {
        $fn_layer = base64_decode($layer);

        $data = MasterCoa::where([
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fn_layer' => $fn_layer - 1,
        ])
            ->get();

        if (empty($data)) {
            return [
                'status' => 200,
                'data' => ['INDUK COA']
            ];
        }

        return ApiFormatter::getResponse($data);
    }

    public function storeUpdate(request $request){
        $validator = Validator::make($request->all(), [
            'fc_coacode' => 'required',
            'fn_layer' => 'required',
            'fc_parentcode' => 'required',
            'fc_coaname' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first(),
            ];
        }
        // dd($request);
        $request->request->add(['fc_branch' => auth()->user()->fc_branch, 'fc_divisioncode' => auth()->user()->fc_divisioncode]);

        DB::beginTransaction();

        try {
            if (!empty($request->type) && $request->type == 'update') {
                $updateRecord = MasterCoa::updateOrCreate([
                    'fc_coacode' => $request->fc_coacode,
                ], $request->all());

                if (!$updateRecord) {
                    throw new \Exception('Oops! Terjadi kesalahan saat mengupdate data');
                }
            } else {
                $countRecord = MasterCoa::where([
                    'fc_coacode' => $request->fc_coacode,
                    'fc_divisioncode' => auth()->user()->fc_divisioncode,
                    'fc_branch' => auth()->user()->fc_branch,
                    'fc_parentcode' => $request->fc_parentcode,
                    'deleted_at' => null
                ])->count();

                if ($countRecord > 0) {
                    throw new \Exception('Mohon maaf, kode COA sudah tersedia');
                }

                $duplicateRecord = MasterCoa::where([
                    'fc_coacode' => $request->fc_parentcode . "." . $request->fc_coacode,
                    'fc_divisioncode' => auth()->user()->fc_divisioncode,
                    'fc_branch' => auth()->user()->fc_branch,
                ])->count();
                
                if ($duplicateRecord > 0) {
                    throw new \Exception('Mohon maaf, terdapat coacode dan parentcode yang sama');
                }
                // dd($duplicateRecord);
                $parentRecord = MasterCoa::where([
                    'fc_coacode' => $request->fc_parentcode,
                    'deleted_at' => null
                ])->first();
    
                if ($parentRecord && $parentRecord->fc_rootstatus == 'T') {
                    $parentRecord->update(['fc_rootstatus' => 'F']);
                }
    

                $insertRecord = MasterCoa::create([
                    'fc_divisioncode' => $request->fc_divisioncode,
                    'fc_branch' => $request->fc_branch,
                    'fc_coacode' => $request->fc_coacode,
                    'fn_layer' => $request->fn_layer,
                    'fc_directpayment' => $request->fc_directpayment,
                    'fc_group' => $request->fc_group,
                    'fc_balancestatus' => $request->fc_balancestatus,
                    'fc_parentcode' => $request->fc_parentcode,
                    'fc_coaname' => $request->fc_coaname,
                    'fv_description' => $request->fv_description,
                ], $request->all());

                if (!$insertRecord) {
                    throw new \Exception('Oops! Terjadi kesalahan saat menambahkan data');
                }
            }

            // Commit transaksi apabila sukses
            DB::commit();

            // Return success response
            return [
                'status' => 201,
                'message' => (!empty($request->type) && $request->type == 'update') ? 'Data berhasil diupdate' : 'Data COA berhasil ditambahkan',
                'link' => '/apps/master-coa'
            ];
        } catch (\Exception $e) {
            // Rollback apabila terjadi error
            DB::rollback();

            // Return error response
            return [
                'status' => 300,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function delete($id)
    {
        $idDecode = base64_decode($id);

        $deleteRecord = MasterCoa::where('id', $idDecode)->delete();

        if ($deleteRecord) {
            return [
                'status' => 200,
                'link' => '/apps/master-coa',
                'message' => "Data Berhasil Dihapus",
            ];
        } else {
            return [
                'status' => 300,
                'message' => "Ooops!! Data Gagal Dihapus ...",
            ];
        }
    }
}
