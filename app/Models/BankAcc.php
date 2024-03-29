<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class BankAcc extends Model
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

    protected $table = 't_bankacc';
    protected $primaryKey = 'fc_bankcode';
    // protected $primaryKey = ['fc_divisioncode', 'fc_branch', 'fc_bankcode'];
    public $incrementing = false;
    protected $guarded = ['type'];
    protected $appends = [];

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode')->withTrashed();
    }

    public function invmst(){
        return $this->belongsTo(InvoiceMst::class, 'fc_bankcode', 'fc_bankcode')->withTrashed();
    }
}
