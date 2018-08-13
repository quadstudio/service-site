<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Contracts\Messagable;
use QuadStudio\Service\Site\Facades\Site;


class Repair extends Model implements Messagable
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
        'address', 'status_id'
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
//        self::updated(function (Repair $repair) {
//
//
//        });
//    }

    public function setStatus($status_id)
    {

        if ($status_id == 5 && $this->getOriginal('status_id') != 5) {

            $this->parts->each(/**
             * @param Part $part
             * @param int $key
             */
                function ($part) {
                    $part->update(['cost' => Site::round($part->cost())]);
                });
            $this->update([
                'status_id' => $status_id,
                'cost_work' => $this->equipmentCostWork,
                'cost_road' => $this->equipmentCostRoad,

            ]);
        } else {
            $this->update(['status_id' => $status_id]);
        }
    }

    /**
     * Узнать, можно ли сменить статус отчета по ремонту
     *
     * @param $status_id
     * @return bool
     */
    public function canSetStatus($status_id)
    {
        switch ($status_id) {
            case 5:
                return $this->hasEquipment() && $this->parts->every(function ($part, $key) {
                        return $part->hasPrice();
                    });
            default:
                return true;
        }
    }

    public function hasEquipment()
    {
        return $this->serial->product->hasEquipment();
    }

    /**
     * Файлы
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function detachFiles()
    {
        foreach ($this->files as $file) {
            $file->fileable_id = null;
            $file->fileable_type = null;
            $file->save();
        }
    }

    public function created_at($time = false)
    {
        return !is_null($this->created_at) ? Carbon::instance($this->created_at)->format('d.m.Y' . ($time === true ? ' H:i' : '')) : '';
    }

    public function date_launch()
    {
        return !is_null($this->date_launch) ? Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->date_launch))->format('d.m.Y') : '';
    }

    public function date_trade()
    {
        return !is_null($this->date_trade) ? Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->date_trade))->format('d.m.Y') : '';
    }

    public function date_call()
    {
        return !is_null($this->date_call) ? Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->date_call))->format('d.m.Y') : '';
    }

    public function date_repair()
    {
        return !is_null($this->date_repair) ? Carbon::instance(\DateTime::createFromFormat('Y-m-d', $this->date_repair))->format('d.m.Y') : '';
    }

    public function cost_total()
    {
        return $this->cost_work() + $this->cost_road() + $this->cost_parts();
    }

    /**
     * Стоимость работ
     *
     * @return float
     */
    public function cost_work()
    {
        if ($this->allow_work == 0 || !$this->hasEquipment()) {
            return 0;
        }
        switch ($this->getAttribute('status_id')) {
            case 5:
            case 6:
                return $this->getAttribute('cost_work');
            default:
                return $this->equipmentCostWork;
        }
    }

    /**
     * Стоимость дороги
     *
     * @return float
     */
    public function cost_road()
    {
        if ($this->allow_road == 0 || !$this->hasEquipment()) {
            return 0;
        }
        switch ($this->getAttribute('status_id')) {
            case 5:
            case 6:
                return $this->getAttribute('cost_road');
                break;
            default:
                return $this->equipmentCostRoad;
        }
    }

    /**
     * Стоимлсть запчастей
     *
     * @return float
     */
    public function cost_parts()
    {
        if ($this->allow_parts == 0) {
            return 0;
        }

        return $this->parts->sum('total');
    }

    public function getEquipmentCostWorkAttribute()
    {
        return $this->serial->product->equipment->cost_work * $this->rates;
    }

    public function getEquipmentCostRoadAttribute()
    {
        return $this->serial->product->equipment->cost_road * $this->rates;
    }

    /**
     * @return float
     */
    public function getRatesAttribute()
    {
        return Site::currencyRates($this->serial->product->equipment->currency, $this->user->currency);
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

    public function statuses()
    {
        return RepairStatus::whereIn('id', config('site.repair_status_transition.' . (Auth::user()->admin == 1 ? 'admin' : 'user') . '.' . $this->getAttribute('status_id'), []));
    }

    /**
     * Сообщения
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function messages()
    {
        return $this->morphMany(Message::class, 'messagable');
    }

    /**
     * Ошибки
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fails()
    {
        return $this->hasMany(RepairFail::class);
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
     * Страна
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
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
     * Торговая организация
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trade()
    {
        return $this->belongsTo(Trade::class);
    }

    /**
     * Сервисный инженер
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function engineer()
    {
        return $this->belongsTo(Engineer::class);
    }

    /**
     * Ввод в эксплуатацию
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function launch()
    {
        return $this->belongsTo(Launch::class);
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

    function name()
    {
        return trans('site::repair.repair') . ' ' . $this->getAttribute('number');
    }

    function route()
    {
        //return '';
        return route((Auth::user()->admin == 1 ? 'admin.' : '') . 'repairs.show', [$this, '#messages-list']);
    }
}
