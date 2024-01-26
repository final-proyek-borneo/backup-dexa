<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class MutasiDetail extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_mutasidtl';
    protected $primaryKey = 'fc_mutationrownum';
    public $incrementing = false;
    protected $guarded = ['type'];


    public function stock(){
        return $this->belongsTo(Stock::class, 'fc_stockcode', 'fc_stockcode')->withTrashed();
    }

    public function invstore(){
        return $this->hasOne(Invstore::class, 'fc_barcode', 'fc_barcode');
    }

    public function mutasimst(){
        return $this->hasOne(MutasiDetail::class,'fc_mutationno','fc_mutationno');
    }
}
