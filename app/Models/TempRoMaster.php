<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class TempRoMaster extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_tempromst';
    protected $primaryKey = 'fc_rono';
    public $incrementing = false;
    protected $guarded = ['type'];
    public $timestamps = true;

    public function pomst(){
        return $this->belongsTo(PoMaster::class, 'fc_pono', 'fc_pono');
    }

    // relasi TempRoDetail
    public function temprodtl(){
        return $this->hasMany(TempRoDetail::class, 'fc_rono', 'fc_rono');
    }

    // public function rodtl(){
    //     return $this->hasMany(DoDetail::class, 'fc_dono', 'fc_dono');
    // }
    
    // public function invmst(){
    //     return $this->hasOne(InvMaster::class, 'fc_dono', 'fc_dono');
    // }

   
    

}
