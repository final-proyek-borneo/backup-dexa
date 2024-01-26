<?php

namespace App\Exports;

use App\Models\DoMaster;
use App\Models\ReturMaster;
use App\Models\RoMaster;
use App\Models\SoMaster;
use Doctrine\DBAL\Types\Type;
use Illuminate\Contracts\View\View as ViewView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use View;

class ReturExport implements FromView, ShouldAutoSize
{
    use Exportable;
    private $masterRetur;
    private $status;
    public function __construct(){
        $this->masterRetur = ReturMaster::with('domst.somst', 'returdtl.invstore.stock')->where('fc_branch', auth()->user()->fc_branch)->get();
    }

    public function view(): ViewView{
        return view('apps.excel.master_retur',[
            'masterRetur' => $this->masterRetur
        ]);
    }
}
