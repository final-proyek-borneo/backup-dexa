<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class SoMaster extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_somst';
    protected $primaryKey = 'fc_sono';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function branch()
    {
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode')->withTrashed();
    }

    public function member_tax_code()
    {
        return $this->belongsTo(TransaksiType::class, 'fc_membertaxcode', 'fc_kode')->withTrashed()->where('fc_trx', 'like', '%TAX%');
    }

    public function sales()
    {
        return $this->belongsTo(Sales::class, 'fc_salescode', 'fc_salescode')->withTrashed();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'fc_membercode', 'fc_membercode')->withTrashed();
    }

    public function tempsodtl()
    {
        return $this->hasMany(TempSoDetail::class, 'fc_sono', 'fc_sono')->withTrashed();
    }

    public function tempsopay()
    {
        return $this->hasMany(TempSoPay::class, 'fc_sono', 'fc_sono');
    }

    // one to one
    public function domst()
    {
        return $this->hasOne(DoMaster::class, 'fc_sono', 'fc_sono');
    }

    // one to one
    public function tempdomst()
    {
        return $this->hasOne(TempDoMaster::class, 'fc_sono', 'fc_sono');
    }

    public function mutasimst()
    {
        return $this->belongsTo(MutasiMaster::class, 'fc_sono', 'fc_sono');
    }

    // sodtl
    public function sodtl()
    {
        return $this->hasMany(SoDetail::class, 'fc_sono', 'fc_sono');
    }
}
