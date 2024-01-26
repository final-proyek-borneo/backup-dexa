<?php

namespace App\Exports;

use App\Models\DoMaster;
use App\Models\PoDetail;
use App\Models\PoMaster;
use App\Models\RoMaster;
use App\Models\SoMaster;
use Doctrine\DBAL\Types\Type;
use Illuminate\Contracts\View\View as ViewView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use View;

class PurchaseOrderExport implements FromView, ShouldAutoSize
{
    use Exportable;
    private $masterPo;
    private $status;
    public function __construct($status){
      
        $this->status = $status;
        if($this->status == 'A'){
            $this->masterPo = PoMaster::with('supplier', 'podtl')->where('fc_branch', auth()->user()->fc_branch)->get();
           
        }else{
            $this->masterPo = PoMaster::with('supplier', 'podtl')->where('fc_branch', auth()->user()->fc_branch)->where('fc_postatus', $status)->get();
        }
       
    }

    public function view(): ViewView{
        return view('apps.excel.master_po',[
            'masterPo' => $this->masterPo
        ]);
    }
}
