<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class RoMaster extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_romst';
    protected $primaryKey = 'fc_rono';
    public $incrementing = false;
    protected $guarded = ['type'];
    public $timestamps = true;

    public function pomst(){
        return $this->belongsTo(PoMaster::class, 'fc_pono', 'fc_pono');
    }

    public function rodtl(){
        return $this->hasMany(RoDetail::class, 'fc_rono', 'fc_rono');
    }
    
    public function invmst(){
        return $this->hasOne(InvoiceMst::class, 'fc_rono', 'fc_rono');
    }

    public function warehouse(){
        return $this->hasOne(Warehouse::class, 'fc_warehousecode', 'fc_warehousecode');
    }
    

}
