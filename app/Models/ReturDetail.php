<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class ReturDetail extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_returdtl';
    protected $primaryKey = 'fc_returno';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function returmst(){
        return $this->hasOne(ReturMaster::class, 'fc_returno', 'fc_returno');
    }

    public function invstore(){
        return $this->hasOne(Invstore::class, 'fc_barcode', 'fc_barcode');
    }
}
