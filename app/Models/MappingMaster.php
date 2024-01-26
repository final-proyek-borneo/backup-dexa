<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class MappingMaster extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_mappingmst';
    protected $primaryKey = 'fc_mappingcode';
    public $incrementing = false;
    protected $guarded = ['type'];
    
    public function trxaccountingmst(){
        return $this->belongsTo(TrxAccountingMaster::class, 'fc_mappingcode', 'fc_mappingcode');
    }

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode')->withTrashed();
    }

    public function tipe(){
        return $this->hasOne(TransaksiType::class, 'fc_kode', 'fc_mappingcashtype');
    }

    public function transaksi(){
        return $this->hasOne(TransaksiType::class, 'fc_kode', 'fc_mappingtrxtype');
    }

}
