<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class MappingUser extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_mappinguser';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = ['id'];

    public function mappingmst(){
        return $this->hasOne(MappingMaster::class, 'fc_mappingcode', 'fc_mappingcode');
    }

    public function user(){
        return $this->hasOne(User::class, 'fc_userid', 'fc_userid')->where('fl_hold', 'F');
    }

}
