<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class TempReturMaster extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_tempreturmst';
    protected $primaryKey = 'fc_returno';
    public $incrementing = false;
    protected $guarded = ['type'];

    // returdtl
    public function tempreturdtl(){
     return $this->hasMany(TempReturDetail::class, 'fc_returno', 'fc_returno');
     }

     // domst
    public function domst(){
     return $this->belongsTo(DoMaster::class, 'fc_dono', 'fc_dono');
    }

}
