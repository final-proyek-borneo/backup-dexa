<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class GoodReception extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_goodsreception';
    protected $primaryKey = 'fc_grno';
    public $incrementing = false;
    protected $guarded = ['type'];
    public $timestamps = true;

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'fc_suppliercode', 'fc_suppliercode')->withTrashed();
    }

}
