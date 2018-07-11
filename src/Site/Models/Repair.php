<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Repair extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'serial', 'number', 'warranty_number', 'warranty_period',
        'cost_work', 'cost_road',
        'allow_work', 'allow_road', 'allow_parts',
        'date_launch', 'date_trade', 'date_call',
        'date_repair',
        'engineer_id', 'trade_id', 'launch_id',
        'reason_call', 'diagnostics', 'works',
        'recommends','remarks','country_id',
        'client','phone_primary','phone_secondary',
        'address',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', ''). 'repairs';
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            $model->user_id = Auth::user()->getAuthIdentifier();
        });

//        self::created(function($model){
//            // ... code here
//        });
//
//        self::updating(function($model){
//            // ... code here
//        });
//
//        self::updated(function($model){
//            // ... code here
//        });
//
//        self::deleting(function($model){
//            // ... code here
//        });

//        self::deleted(function($model){
//            // ... code here
//        });
    }

    /**
     * Файлы
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }

    /**
     * Статус отчета по ремонту
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(RepairStatus::class);
    }

//    /**
//     * Scope a query to only enabled countries.
//     *
//     * @param \Illuminate\Database\Eloquent\Builder $query
//     * @return \Illuminate\Database\Eloquent\Builder
//     */
//    public function scopeEnabled($query)
//    {
//        return $query->where('enabled', 1);
//    }

}
