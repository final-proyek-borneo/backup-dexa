<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class MappingDetail extends Model
{
    use HasFactory, Blameable, CompositeKey, LogsActivity;

    protected static $logAttribute = ["*"];
    protected $table = 't_mappingdtl';
    protected $primaryKey = 'fc_mappingcode';
    public $incrementing = false;
    protected $guarded = ['type'];

    // master_coa
    public function mst_coa()
    {
        return $this->belongsTo(MasterCoa::class, 'fc_coacode', 'fc_coacode');
    }
}
