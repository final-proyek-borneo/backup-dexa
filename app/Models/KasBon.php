<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasBon extends Model
{
    use HasFactory;

    protected static $logAttributes = ["*"];

    protected $table = 't_kasbon';
    protected $primaryKey = 'fc_kasbonno';
    // protected $primaryKey = ['fc_divisioncode', 'fc_branch', 'fc_stockcode'];
    public $incrementing = false;
    protected $guarded = ['type'];
    protected $appends = [];
}
