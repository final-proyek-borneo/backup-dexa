<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class InvMaster extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_invmst';
    protected $primaryKey = 'fc_invno';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function domst(){
        return $this->belongsTo(DoMaster::class, 'fc_dono', 'fc_dono');
    }

    // coba fess
    public function romst(){
        return $this->belongsTo(RoMaster::class, 'fc_rono', 'fc_rono');
    }
}
