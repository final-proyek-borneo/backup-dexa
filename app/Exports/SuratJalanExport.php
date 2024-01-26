<?php

namespace App\Exports;

use App\Models\DoMaster;
use App\Models\RoMaster;
use App\Models\SoMaster;
use Doctrine\DBAL\Types\Type;
use Illuminate\Contracts\View\View as ViewView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use View;

class SuratJalanExport implements FromView, ShouldAutoSize
{
    use Exportable;
    private $masterSuratJalan;
    private $status;
    public function __construct($status){
        $this->status = $status;
        if($this->status == 'A'){
            $this->masterSuratJalan = DoMaster::with('somst.customer', 'dodtl.invstore.stock')->where('fc_branch', auth()->user()->fc_branch)->get();
        }else{
            $this->masterSuratJalan = DoMaster::with('somst.customer', 'dodtl.invstore.stock')->where('fc_branch', auth()->user()->fc_branch)->where('fc_dostatus', $status)->get();
        }
       
    }

    public function view(): ViewView{
        return view('apps.excel.master_suratjalan',[
            'masterSuratJalan' => $this->masterSuratJalan
        ]);
    }
}
