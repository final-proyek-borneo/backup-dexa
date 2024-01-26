<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Giro extends Model
{
    use \Awobaz\Compoships\Compoships, HasFactory, Blameable, CompositeKey, LogsActivity;

    protected static $logAttributes = ["*"];

    protected $table = 't_giro';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode')->withTrashed();
    }

    public function transaksi(){
        return $this->hasOne(TrxAccountingMaster::class, 'fc_trxno', 'fc_trxno');
    }

    public function coa(){
        return $this->hasOne(MasterCoa::class, 'fc_coacode', 'fc_coacode');
    }
}
