<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class MasterCoa extends Model
{
    use HasFactory, LogsActivity, Blameable, CompositeKey, SoftDeletes;

    protected static $logAttributes = ["*"];
    protected $table = 't_coa';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = ['type'];
    protected $appends = [];

    public function branch(){
       return $this->hasOne(TransaksiType::class, 'fc_kode', 'fc_branch')->where('fc_trx', 'BRANCH')->withTrashed();
    }

    public function parent(){
        return $this->hasOne(MasterCoa::class, 'fc_coacode', 'fc_parentcode')->withTrashed();
    }

    public function children(){
        return $this->hasMany(MasterCoa::class, 'fc_parentcode', 'fc_coacode')->withTrashed();
    }

    public function transaksitype(){
        return $this->hasOne(TransaksiType::class, 'fc_kode', 'fc_group')->withTrashed();
    }

    // mappingdtl
    public function mappingdtl_coa()
    {
        return $this->hasMany(MappingDetail::class, 'fc_coacode', 'fc_coacode');
    }
}
