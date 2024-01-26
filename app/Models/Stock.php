<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Blameable;
use App\Traits\CompositeKey;
use App\Helpers\Convert;

class Stock extends Model
{
    use \Awobaz\Compoships\Compoships, HasFactory, Blameable, SoftDeletes, LogsActivity, CompositeKey;

    protected static $logAttributes = ["*"];

    protected $table = 't_stock';
    protected $primaryKey = 'fc_stockcode';
    // protected $primaryKey = ['fc_divisioncode', 'fc_branch', 'fc_stockcode'];
    public $incrementing = false;
    protected $guarded = ['type'];
    protected $appends = [];

    public function GetFmPriceDefaultAttribute()
    {
        return number_format($this->attributes['fm_price_default'], 2, ",", ".");
    }

    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    public function branch()
    {
        return $this->belongsTo(TransaksiType::class, 'fc_branch', 'fc_kode')->withTrashed();
    }

    public function namepack()
    {
        return $this->belongsTo(TransaksiType::class, 'fc_namepack', 'fc_kode')->withTrashed();
    }

    public function type_stock1()
    {
        return $this->belongsTo(TransaksiType::class, 'fc_typestock1', 'fc_kode')->withTrashed();
    }

    public function type_stock2()
    {
        return $this->belongsTo(TransaksiType::class, 'fc_typestock2', 'fc_kode')->withTrashed();
    }

    public function tempsodetail()
    {
        return $this->hasMany(TempSoDetail::class, 'fc_stockcode', 'fc_stockcode');
    }

    public function invstore()
    {
        return $this->hasMany(Invstore::class, ['fc_stockcode'], ['fc_stockcode']);
    }

    // sodtl
    public function sodtl()
    {
        return $this->hasMany(SoDetail::class, 'fc_stockcode', 'fc_stockcode');
    }

    // RoDetail
    public function rodetail()
    {
        return $this->hasMany(RoDetail::class, 'fc_stockcode', 'fc_stockcode');
    }

    // TempRoDetail
    public function temprodetail()
    {
        return $this->hasMany(TempRoDetail::class, 'fc_barcode', 'fc_barcode');
    }

    // StockCustomer
    public function stockcustomer()
    {
        return $this->hasMany(StockCustomer::class, 'fc_stockcode', 'fc_stockcode')->withTrashed();;
    }

    // podetail
    public function podetail()
    {
        return $this->hasMany(PoDetail::class, 'fc_stockcode', 'fc_stockcode');
    }
}
