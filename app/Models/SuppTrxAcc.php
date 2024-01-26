<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SuppTrxAcc extends Model
{
    use HasFactory, Blameable, CompositeKey, LogsActivity;


    protected static $logAttributes = ["*"];

    protected $table = 't_supptrxacc';
    protected $primaryKey = 'fc_trxno';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function coamst(){
        return $this->hasOne(MasterCoa::class, 'fc_coacode', 'fc_coacode');
    }

    public function payment(){
        return $this->hasOne(TransaksiType::class, 'fc_kode', 'fc_paymentmethod')->where('fc_trx', 'PAYMENTACC');
    }
}
