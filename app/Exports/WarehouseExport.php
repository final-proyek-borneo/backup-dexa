<?php

namespace App\Exports;

use App\Models\Invstore;
use App\Models\SoMaster;
use App\Models\Warehouse;
use Illuminate\Contracts\View\View as ViewView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use View;

class WarehouseExport implements FromView, ShouldAutoSize
{
    use Exportable;
    private $gudang;
    private $fc_warehousecode;
    public function __construct($fc_warehousecode){
       // decode fc_warehousecode
         $this->fc_warehousecode = $fc_warehousecode;
         $this->gudang['gudang_mst'] = Warehouse::where('fc_warehousecode', $this->fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->first();
         $this->gudang['gudang_dtl'] = Invstore::with('stock')->where('fc_warehousecode', $this->fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->get();
    }

    public function view(): ViewView{
        return view('apps.excel.warehouse',[
            'gudang' => $this->gudang
        ]);
    }
}
