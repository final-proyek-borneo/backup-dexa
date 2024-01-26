<?php

namespace App\Exports;

use App\Models\MutasiMaster;
use App\Models\RoMaster;
use App\Models\SoMaster;
use Doctrine\DBAL\Types\Type;
use Illuminate\Contracts\View\View as ViewView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use View;

class MutasiExport implements FromView, ShouldAutoSize
{
    use Exportable;
    private $masterMutasi;
    private $status;
    public function __construct($status){
        $this->status = $status;
        if($this->status == 'INTERNAL'){
            $this->masterMutasi =  MutasiMaster::with('mutasidtl.invstore.stock','warehouse_start', 'warehouse_destination', 'somst')->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_type_mutation', $status)
            ->get();
        }else if($this->status == 'EKSTERNAL'){
            $this->masterMutasi =  MutasiMaster::with('mutasidtl.invstore.stock','warehouse_start', 'warehouse_destination', 'somst')->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_type_mutation', $status)
            ->get();
        }else{
            $this->masterMutasi = MutasiMaster::with('mutasidtl.invstore.stock','warehouse_start', 'warehouse_destination', 'somst')->where('fc_branch', auth()->user()->fc_branch)->get();
        }
    }

    public function view(): ViewView{
        return view('apps.excel.master_mutasi',[
            'masterMutasi' => $this->masterMutasi
        ]);
    }
}
