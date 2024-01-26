<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class InvoiceMst extends Model
{
    use HasFactory, Blameable, CompositeKey, LogsActivity;

    protected static $logAttribute = ["*"];
    protected $table = 't_invmst';
    protected $primaryKey = 'fn_invno';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function invdtl(){
        return $this->hasMany(InvoiceDtl::class, 'fc_invno','fc_invno');
    }

    public function somst(){
        return $this->hasone(SoMaster::class, 'fc_sono', 'fc_suppdocno');
    }
    
    public function domst(){
        return $this->hasone(DoMaster::class, 'fc_dono', 'fc_child_suppdocno');
    }

    public function pomst(){
        return $this->hasone(PoMaster::class, 'fc_pono', 'fc_suppdocno');
    }

    public function romst(){
        return $this->hasone(RoMaster::class, 'fc_rono', 'fc_child_suppdocno');
    }

    public function customer(){
        return $this->hasOne(Customer::class, 'fc_membercode', 'fc_entitycode');
    }

    public function supplier(){
        return $this->hasOne(Supplier::class, 'fc_suppliercode', 'fc_entitycode');
    }

    public function bank(){
        return $this->hasOne(BankAcc::class, 'fc_bankcode', 'fc_bankcode');
    }

    public function user(){
        return $this->hasOne(User::class, 'fc_userid', 'fc_accessorid');
    }
}
