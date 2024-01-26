<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class Invstore extends Model
{
    use \Awobaz\Compoships\Compoships, HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_invstore';
    protected $primaryKey = 'fc_barcode';
    public $incrementing = false;
    protected $guarded = ['type'];


    public function stock()
    {
        return $this->belongsTo(Stock::class, ['fc_stockcode'], ['fc_stockcode'])->withTrashed();
    }

    // relasi dengan tabel dodtl
    public function dodtl()
    {
        return $this->hasMany(DoDetail::class, 'fc_barcode', 'fc_barcode');
    }

    public function tempdodtl()
    {
        return $this->hasMany(TempDoDetail::class, ['fc_barcode', 'fc_warehousecode'], ['fc_barcode', 'fc_warehousecode']);
    }

    public function tempmutasidetail()
    {
        return $this->hasMany(TempMutasiDetail::class, 'fc_barcode', 'fc_barcode');
    }

    public function mutasidetail()
    {
        return $this->hasMany(MutasiDetail::class, 'fc_barcode', 'fc_barcode');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'fc_warehousecode', 'fc_warehousecode');
    }

    public function scanqr()
    {
        return $this->hasMany(ScanQr::class, 'fc_barcode', 'fc_barcode');
    }

    public function tempinvoicedetail()
    {
        return $this->belongsToMany(TempInvoiceDtl::class, 'fc_detailitem', 'fc_barcode');
    }

    public function invoicedetail()
    {
        return $this->belongsToMany(InvoiceDtl::class, 'fc_detailitem', 'fc_barcode');
    }

    public function stockinquiri()
    {
        return $this->hasMany(StockInquiri::class, ['fc_barcode', 'fc_warehousecode'], ['fc_barcode', 'fc_warehousecode']);
    }

    public function returdtl()
    {
        return $this->hasMany(ReturDetail::class, 'fc_barcode', 'fc_barcode');
    }

    // tempreturdtl
    public function tempreturdtl()
    {
        return $this->hasMany(TempReturDetail::class, 'fc_barcode', 'fc_barcode');
    }
}
