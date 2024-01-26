<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TempInvoiceMst extends Model
{
    use \Awobaz\Compoships\Compoships, HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttribute = ["*"];
    protected $table = 't_tempinvmst';
    protected $primaryKey = 'fc_invno';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function tempinvdtl(){
        return $this->hasMany(TempInvoiceDtl::class, ['fc_invno', 'fc_invtype'], ['fc_invno', 'fc_invtype'])->where([
            'fc_branch' => auth()->user()->fc_branch
        ]);
    }

    public function somst(){
        return $this->hasOne(SoMaster::class, 'fc_sono', 'fc_suppdocno');
    }
    
    public function domst(){
        return $this->hasOne(DoMaster::class, 'fc_dono','fc_child_suppdocno');
    }

    public function pomst(){
        return $this->hasOne(PoMaster::class,'fc_pono', 'fc_suppdocno');
    }

    public function romst(){
        return $this->hasOne(RoMaster::class, 'fc_rono', 'fc_child_suppdocno');
    }

    public function customer(){
        return $this->hasOne(Customer::class, 'fc_membercode','fc_entitycode');
    }

    public function supplier(){
        return $this->hasOne(Supplier::class, 'fc_suppliercode', 'fc_entitycode');
    }

    public function bank(){
        return $this->hasOne(BankAcc::class, 'fc_bankcode', 'fc_bankcode');
    }
}
