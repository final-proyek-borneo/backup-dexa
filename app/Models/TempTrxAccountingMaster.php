<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class TempTrxAccountingMaster extends Model
{
    use HasFactory, Blameable, CompositeKey, LogsActivity;


    protected static $logAttributes = ["*"];

    protected $table = 't_temp_trxaccountingmst';
    protected $primaryKey = 'fc_trxno';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode')->withTrashed();
    }
    
    public function transaksitype(){
        return $this->hasOne(TransaksiType::class, 'fc_kode', 'fc_mappingtrxtype')->where('fc_trx','JOURNALTYPE');
    }

    public function mapping(){
        return $this->belongsTo(MappingMaster::class, 'fc_mappingcode', 'fc_mappingcode');
    }

    // mappinguser
    public function mappinguser(){
        return $this->belongsTo(MappingMaster::class, 'fc_mappinguser', 'fc_mappingcode');
    }

    public function temptrxaccountingdtl(){
        return $this->hasMany(TempTrxAccountingDetail::class, 'fc_trxno', 'fc_trxno');
    }
}
