<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Approvement extends Model
{
    use \Awobaz\Compoships\Compoships, HasFactory, Blameable, CompositeKey, LogsActivity;

    protected static $logAttributes = ["*"];

    protected $table = 't_accountingapp';
    protected $primaryKey = 'fc_approvalno';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode')->withTrashed();
    }
}
