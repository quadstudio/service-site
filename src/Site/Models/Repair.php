<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Facades\Site;

class Repair extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'serial_id', 'number', 'warranty_number', 'warranty_period',
        'cost_work', 'cost_road',
        'allow_work', 'allow_road', 'allow_parts',
        'date_launch', 'date_trade', 'date_call',
        'date_repair',
        'engineer_id', 'trade_id', 'launch_id',
        'reason_call', 'diagnostics', 'works',
        'recommends', 'remarks', 'country_id',
        'client', 'phone_primary', 'phone_secondary',
        'address',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'repairs';
    }

//    public static function boot()
//    {
//        parent::boot();
//
//        self::creating(function ($model) {
//            $model->user_id = Auth::user()->getAuthIdentifier();
//        });
//    }

    /**
     * Файлы
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function detachFiles(){
        foreach ($this->files as $file){
            $file->fileable_id = null;
            $file->fileable_type = null;
            $file->save();
        }
    }

    public function created_at()
    {
        return !is_null($this->created_at) ? Carbon::instance($this->created_at)->format('d.m.Y H:i') : '';
    }

    /**
     * Стоимость дороги
     *
     * @return float
     */
    public function cost_road()
    {
        switch ($this->getAttribute('status_id')) {
            case 5:
            case 6:
                $result = $this->getAttribute('cost_road');
                break;
            default:
                $result = $this->serial->product->equipment->cost_road * Site::currencyRates($this->serial->product->equipment->currency, $this->user->currency);
                break;
        }
        Auth::validate();

        return $result;
    }

    /**
     * Стоимость работ
     *
     * @return float
     */
    public function cost_work()
    {
        switch ($this->getAttribute('status_id')) {
            case 5:
            case 6:
                $result = $this->getAttribute('cost_work');
                break;
            default:
                $result = $this->serial->product->equipment->cost_work * Site::currencyRates($this->serial->product->equipment->currency, $this->user->currency);
                break;
        }

        return $result;
    }

    /**
     * Стоимлсть запчастей
     *
     * @return float
     */
    public function cost_parts()
    {

        switch ($this->getAttribute('status_id')) {
            case 5:
            case 6:
                $result = $this->parts->sum('cost');
                break;
            default:
                $result = $this->parts->sum(function ($part) {
                        return $part->product->prices()->where('type_id', $this->user->price_type_id)->sum('price');
                    }) * Site::currencyRates($this->user->price_type->currency, $this->user->currency);
                break;
        }

        return $result;
    }


    /**
     * Запчасти
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parts()
    {
        return $this->hasMany(Part::class);
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

    /**
     * Пользователь
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Серийный номер
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serial()
    {
        return $this->belongsTo(Serial::class);
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
