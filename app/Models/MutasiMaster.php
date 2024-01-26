<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class MutasiMaster extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_mutasimst';
    protected $primaryKey = 'fc_mutationno';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function somst(){
        return $this->hasOne(SoMaster::class, 'fc_sono', 'fc_sono');
    } 

    public function warehouse(){
        return $this->belongsTo(Warehouse::class, 'fc_warehousecode', 'fc_warehousecode')->withTrashed();
    } 

    public function warehouse_start(){
        return $this->hasOne(Warehouse::class, 'fc_warehousecode', 'fc_startpoint_code');
    } 

    public function warehouse_destination(){
        return $this->hasOne(Warehouse::class, 'fc_warehousecode', 'fc_destination_code');
    }

    // mutasidtl
    public function mutasidtl() {
        return $this->hasMany(MutasiDetail::class,'fc_mutationno','fc_mutationno');
    }
}
