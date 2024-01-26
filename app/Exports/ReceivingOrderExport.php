<?php

namespace App\Exports;

use App\Models\RoMaster;
use App\Models\SoMaster;
use Doctrine\DBAL\Types\Type;
use Illuminate\Contracts\View\View as ViewView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use View;

class ReceivingOrderExport implements FromView, ShouldAutoSize
{
    use Exportable;
    private $masterBpb;
    private $status;
    public function __construct($status){
        $this->status = $status;
        if($this->status == 'P'){
            $this->masterBpb =  RoMaster::with('rodtl.invstore.stock', 'pomst.supplier')->where('fc_rostatus', 'P')->where('fc_branch', auth()->user()->fc_branch)->get();
        }else if($this->status == 'R'){
            $this->masterBpb =  RoMaster::with('rodtl.invstore.stock', 'pomst.supplier')->where('fc_rostatus', 'R')->where('fc_branch', auth()->user()->fc_branch)->get();
        }else{
            $this->masterBpb =  RoMaster::with('rodtl.invstore.stock', 'pomst.supplier')->where('fc_branch', auth()->user()->fc_branch)->get();
        }
    }

    public function view(): ViewView{
        return view('apps.excel.master_bpb',[
            'masterBpb' => $this->masterBpb
        ]);
    }
}
