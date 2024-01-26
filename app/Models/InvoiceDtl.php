<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class InvoiceDtl extends Model
{
    use HasFactory, Blameable, CompositeKey, LogsActivity;

    protected static $logAttribute = ["*"];
    protected $table = 't_invdtl';
    protected $primaryKey = 'fn_invrownum';
    public $incrementing = false;
    protected $guarded = ['type'];

    public function invmst()
    {
        return $this->hasOne(InvoiceMst::class, 'fc_invno', 'fc_invno');
    }

    public function cospertes()
    {
        return $this->hasOne(Cospertes::class, 'fc_cprrcode', 'fc_detailitem');
    }

    public function nameunity()
    {
        return $this->hasOne(TransaksiType::class, 'fc_kode', 'fc_unityname')->where('fc_trx', 'LIKE', '%UNITY%')->withTrashed();
    }

    public function invstore()
    {
        return $this->hasOne(Invstore::class, 'fc_barcode', 'fc_detailitem');
    }
}
