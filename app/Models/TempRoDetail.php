<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class TempRoDetail extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_temprodtl';
    protected $primaryKey = 'fn_rownum';
    public $incrementing = false;
    protected $guarded = ['type'];
    public $timestamps = true;

    public function stock(){
        return $this->belongsTo(Stock::class, 'fc_barcode', 'fc_barcode');
    }

    
    public function tempromst(){
        return $this->belongsTo(TempRoMaster::class, 'fc_rono', 'fc_rono');
    }

    // public function rodtl(){
    //     return $this->hasMany(DoDetail::class, 'fc_dono', 'fc_dono');
    // }
    
    // public function invmst(){
    //     return $this->hasOne(InvMaster::class, 'fc_dono', 'fc_dono');
    // }
    

}
