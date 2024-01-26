<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Builder;
use App\Blameable;
use App\Traits\CompositeKey;

class PoDetail extends Model
{
    use HasFactory, Blameable, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_podtl';
    protected $primaryKey = 'fn_porownum';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function branch(){
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode')->withTrashed();
    }

    public function stock(){
        return $this->belongsTo(Stock::class, 'fc_barcode', 'fc_barcode')->withTrashed();
    }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class, 'fc_warehousecode', 'fc_warehousecode')->withTrashed();
    }

    public function namepack(){
        return $this->belongsTo(TransaksiType::class, 'fc_namepack', 'fc_kode')->withTrashed();
    }

    public function pomst(){
        return $this->belongsTo(PoMaster::class, 'fc_pono', 'fc_pono');
    }
}
