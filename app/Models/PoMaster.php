<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class PoMaster extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_pomst';
    protected $primaryKey = 'fc_pono';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode')->withTrashed();
    }

    public function supplier_tax_code(){
        return $this->belongsTo(TransaksiType::class, 'fc_suppliertaxcode', 'fc_kode')->withTrashed()->where('fc_trx', 'like', '%TAX%');
    }

    public function sales(){
        return $this->belongsTo(Sales::class, 'fc_salescode', 'fc_salescode')->withTrashed();
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'fc_suppliercode', 'fc_suppliercode')->withTrashed();
    }

    public function temppodtl(){
        return $this->hasMany(TempPoDetail::class, 'fc_pono', 'fc_pono')->withTrashed();
    }

    public function podtl(){
        return $this->hasMany(PoDetail::class, 'fc_pono', 'fc_pono');
    }

  
    public function romst(){
        return $this->hasMany(RoMaster::class, 'fc_pono', 'fc_pono');
    }

}
