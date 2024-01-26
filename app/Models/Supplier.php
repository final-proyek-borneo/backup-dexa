<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class Supplier extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected static function boot()
    {
        parent::boot();

        if(auth()->check()){
            static::addGlobalScope('branch', function (Builder $builder) {
                $builder->where('fc_branch', '=', auth()->user()->fc_branch);
            });
        }
    }

    protected $table = 't_supplier';
    protected $primaryKey = 'fc_suppliercode';
    // protected $primaryKey = ['fc_divisioncode', 'fc_branch', 'fc_suppliercode'];
    public $incrementing = false;
    protected $guarded = ['type'];
    protected $appends = [];

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode')->withTrashed();
    }

    public function supplier_legal_status(){
        return $this->belongsTo(TransaksiType::class, 'fc_supplierlegalstatus', 'fc_kode')->withTrashed()->where('fc_trx', 'like', '%CUST_LEGAL%');
    }

    public function supplier_nationality(){
        return $this->belongsTo(TransaksiType::class, 'fc_suppliernationality', 'fc_kode')->withTrashed();
    }
    
    public function supplier_type_business(){
        return $this->belongsTo(TransaksiType::class, 'fc_suppliertypebusiness', 'fc_kode')->withTrashed()->where('fc_trx', 'like', '%MEMBER_BUSI_TYPE%');
    }

    public function supplier_tax_code(){
        return $this->belongsTo(TransaksiType::class, 'fc_suppliertaxcode', 'fc_kode')->withTrashed()->where('fc_trx', 'like', '%CUST_TAXTYPE%');
    }

    public function supplier_bank1(){
        return $this->belongsTo(BankAcc::class, 'fc_supplierbank1', 'fc_bankcode')->withTrashed();
    }

    public function supplier_bank2(){
        return $this->belongsTo(BankAcc::class, 'fc_supplierbank2', 'fc_bankcode')->withTrashed();
    }

    public function supplier_bank3(){
        return $this->belongsTo(BankAcc::class, 'fc_supplierbank3', 'fc_bankcode')->withTrashed();
    }

    public function supplier_typebranch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branchtype', 'fc_kode')->withTrashed()->where('fc_trx','CUST_TYPEOFFICE');
    }


    // pomst
    public function pomst(){
        return $this->hasMany(PoMaster::class, 'fc_suppliercode', 'fc_suppliercode')->withTrashed();
    }

    public function invmst(){
        return $this->hasMany(InvoiceMst::class, 'fc_membercode', 'fc_entitycode');
    }
    

}
