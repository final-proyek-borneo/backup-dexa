<?php

// create model class TempSoPay
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class TempSoPay extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_tempsopay';
    protected $primaryKey = 'fn_sopayrownum';
    public $incrementing = false;
    protected $guarded = ['type'];
    public $timestamps = true;

    public function transaksitype(){
        return $this->belongsTo(TransaksiType::class, 'fc_sopaymentcode', 'fc_kode')->withTrashed();
    }

    public function tempsomst(){
        return $this->belongsTo(TempSoMaster::class, 'fc_sono', 'fc_sono');
    }

}