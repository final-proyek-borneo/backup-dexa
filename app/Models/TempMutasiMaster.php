<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class TempMutasiMaster extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_temp_mutasimst';
    protected $primaryKey = 'fc_mutationno';
    public $incrementing = false;
    protected $guarded = ['type'];


    public function warehouse_start(){
        return $this->hasOne(Warehouse::class, 'fc_warehousecode', 'fc_startpoint_code');
    } 

    public function warehouse_destination(){
        return $this->hasOne(Warehouse::class, 'fc_warehousecode', 'fc_destination_code');
    }
}
