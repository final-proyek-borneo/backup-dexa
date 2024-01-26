<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class TempReturDetail extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_tempreturdtl';
    protected $primaryKey = 'fc_returno';
    public $incrementing = false;
    protected $guarded = ['type'];

   // tempreturmaster
    public function tempreturmaster(){
     return $this->belongsTo(TempReturMaster::class, 'fc_returno', 'fc_returno')->withTrashed();
     }

    // domst
    public function domst(){
     return $this->belongsTo(DoMaster::class, 'fc_dono', 'fc_dono')->withTrashed();
    }

    // returmst
    public function returmst(){
     return $this->belongsTo(TempReturMaster::class, 'fc_returno', 'fc_returno');
    }

    // invstore
    public function invstore(){
     return $this->hasOne(Invstore::class, 'fc_barcode', 'fc_barcode');
    }

}
