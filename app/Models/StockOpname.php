<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class StockOpname extends Model
{
    use \Awobaz\Compoships\Compoships, HasFactory, Blameable, CompositeKey, LogsActivity;

    protected static $logAttributes = ["*"];

    protected $table = 't_stockopnamemst';
    protected $primaryKey = 'fc_stockopname_no';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function warehouse(){
        return $this->hasOne(Warehouse::class, 'fc_warehousecode', 'fc_warehousecode')->withTrashed();
    }
}
