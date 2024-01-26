<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class Sales extends Model
{
    use HasFactory, Blameable, SoftDeletes, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_sales';
    protected $primaryKey = 'fc_salescode';
    public $incrementing = false;
    protected $guarded = ['type'];
    protected $appends = [];

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode')->withTrashed();
    }

    public function sales_type(){
        return $this->belongsTo(TransaksiType::class, 'fc_salestype', 'fc_kode')->withTrashed();
    }

    public function sales_level(){
        return $this->belongsTo(TransaksiType::class, 'fn_saleslevel', 'fc_kode')->withTrashed();
    }

    public function sales_bank1(){
        return $this->belongsTo(BankAcc::class, 'fc_salesbank1', 'fc_bankcode')->withTrashed();
    }

    public function sales_bank2(){
        return $this->belongsTo(BankAcc::class, 'fc_salesbank2', 'fc_bankcode')->withTrashed();
    }

    public function sales_bank3(){
        return $this->belongsTo(BankAcc::class, 'fc_salesbank3', 'fc_bankcode')->withTrashed();
    }
}
