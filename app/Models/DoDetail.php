<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class DoDetail extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_dodtl';
    protected $primaryKey = 'fn_rownum';
    public $incrementing = false;
    protected $guarded = ['type'];
    public $timestamps = true;


    // relasi dengan tabel invstore
    public function invstore(){
        return $this->hasOne(Invstore::class, 'fc_barcode', 'fc_barcode');
    }

    // relasi dengan tabel stock
    public function stock(){
        return $this->belongsTo(Stock::class, 'fc_branch', 'fc_stockcode');
    }

    public function domst(){
        // relasi dengan tabel domst
        return $this->belongsTo(DoMaster::class, 'fc_dono', 'fc_dono');
    }



}
