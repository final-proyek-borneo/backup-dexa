<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TempDoMaster extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_tempdomst';
    protected $primaryKey = 'fc_dono';
    public $incrementing = false;
    protected $guarded = ['type'];
    public $timestamps = true;

    public function somst()
    {
        return $this->belongsTo(SoMaster::class, 'fc_sono', 'fc_sono');
    }

    public function dodtl()
    {
        return $this->hasMany(TempDoDetail::class, 'fc_dono', 'fc_dono');
    }
}
