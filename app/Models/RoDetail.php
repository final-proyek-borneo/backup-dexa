<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class RoDetail extends Model
{
    use \Awobaz\Compoships\Compoships, HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_rodtl';
    protected $primaryKey = 'fn_rownum';
    public $incrementing = false;
    protected $guarded = ['type'];
    public $timestamps = true;


    // relasi dengan tabel invstore
    public function invstore(){
        return $this->belongsTo(Invstore::class, 'fc_stockcode', 'fc_stockcode');
    }

    // relasi dengan tabel stock
    public function stock(){
        return $this->belongsTo(Stock::class, 'fc_branch', 'fc_stockcode');
    }

    public function romst(){
        // relasi dengan tabel domst
        return $this->belongsTo(RoMaster::class, 'fc_rono', 'fc_rono');
    }



}
