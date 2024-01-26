<?php

namespace App\Models;

use App\Blameable;
use App\Traits\CompositeKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TempInvoiceDtl extends Model
{
    use \Awobaz\Compoships\Compoships, HasFactory, Blameable, CompositeKey, LogsActivity;

    protected static $logAttribute = ["*"];
    protected $table = 't_tempinvdtl';
    protected $primaryKey = 'fn_invrownum';
    public $incrementing = false;
    protected $guarded = ['type'];
    

    public function tempinvmst(){
        return $this->belongsTo(TempInvoiceMst::class, ['fc_invno', 'fc_invtype'], ['fc_invno', 'fc_invtype'])->where([
            'fc_branch' => auth()->user()->fc_branch
        ]);
    }

    public function cospertes(){
        return $this->hasOne(Cospertes::class, 'fc_cprrcode', 'fc_detailitem');
    }

    public function nameunity(){
        return $this->hasOne(TransaksiType::class, 'fc_kode', 'fc_unityname')->where('fc_trx', 'LIKE', '%UNITY%')->withTrashed();
    }

    public function keterangan(){
        return $this->hasOne(TransaksiType::class, 'fc_kode', 'fc_detailitem')->where('fc_trx', 'LIKE', '%OTHEREXPENSE%')->withTrashed();
    }

    public function invstore(){
        return $this->hasOne(Invstore::class, ['fc_barcode'],['fc_detailitem']);
    }


}
