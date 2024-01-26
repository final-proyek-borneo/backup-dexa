<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class StockInquiri extends Model
{
    use \Awobaz\Compoships\Compoships, HasFactory, Blameable, CompositeKey, LogsActivity;

    protected static $logAttributes = ["*"];

    protected $table = 't_inquiri';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function warehouse(){
        return $this->hasOne(Warehouse::class, 'fc_warehousecode', 'fc_warehousecode')->withTrashed();
    }

    public function invstore(){
        return $this->hasOne(Invstore::class, ['fc_barcode','fc_warehousecode'], ['fc_barcode','fc_warehousecode']);
    }
}
