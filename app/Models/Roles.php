<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;
use Spatie\Permission\Traits\HasRoles;

class Roles extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey, HasRoles;

    protected static $logAttributes = ["*"];

    protected $table = 'roles';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = ['id'];
    public $timestamps = true;

    

}
