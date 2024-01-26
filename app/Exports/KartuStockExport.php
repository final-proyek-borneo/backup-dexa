<?php

namespace App\Exports;

use App\Models\StockInquiri;
use Doctrine\DBAL\Types\Type;
use Illuminate\Contracts\View\View as ViewView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use View;

class KartuStockExport implements FromView, ShouldAutoSize
{
    use Exportable;
    private $kartuStock;
    private $range_date;
    public function __construct($kartuStock, $range_date)
    {
        $this->kartuStock = $kartuStock;
        $this->range_date = $range_date;
    }


    public function view(): ViewView{
        return view('apps.excel.kartu_stock',[
            'kartu_stock' => $this->kartuStock,
            'range_date' => $this->range_date
        ]);
    }
}
