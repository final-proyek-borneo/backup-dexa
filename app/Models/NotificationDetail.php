<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class NotificationDetail extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_notificationdtl';
    protected $primaryKey = 'fc_notificationcode';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function notifmst(){
        return $this->belongsTo(NotificationMaster::class, 'fc_notificationcode', 'fc_notificationcode');
    }

}
