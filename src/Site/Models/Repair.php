<?php

namespace QuadStudio\Service\Site\Models;

use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Contracts\Messagable;
use QuadStudio\Service\Site\Facades\Site;
use QuadStudio\Service\Site\Pdf\RepairPdf;


class Repair extends Model implements Messagable
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'serial_id', 'product_id', 'contragent_id',
        'cost_difficulty', 'cost_distance',
        'distance_id', 'difficulty_id',
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
        $this->table = 'repairs';
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

//            $this->parts->each(/**
//             * @param Part $part
//             * @param int $key
//             */
//                function ($part) {
//                    $part->update(['cost' => Site::round($part->cost())]);
//                });
            $this->update([
                'status_id'       => $status_id,
                'cost_difficulty' => $this->getAttribute('difficultyCost'),
                'cost_distance'   => $this->getAttribute('distanceCost'),

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
                return $this->parts()->count() == 0 || $this->parts->every(function ($part) {
                        return $part->hasPrice();
                    });
            default:
                return true;
        }
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

    public function check()
    {
        return $this->checkParts() && $this->checkContragent();
    }

    public function checkParts()
    {
        return $this->getAttribute('allow_parts') == 0
            || $this->parts->every(function ($part) {
                return $part->hasPrice();
            });
    }

    public function checkContragent()
    {
        return $this->contragent->check();
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


    public function getTotalCostAttribute()
    {
        return $this->cost_difficulty() + $this->cost_distance() + $this->cost_parts();
    }

    /**
     * Стоимость работ
     *
     * @return float
     */
    public function cost_difficulty()
    {
        switch ($this->getAttribute('status_id')) {
            case 5:
            case 6:
                return $this->getAttribute('cost_difficulty');
            default:
                return $this->getAttribute('difficultyCost');
        }
    }

    /**
     * Стоимость дороги
     *
     * @return float
     */
    public function cost_distance()
    {
        switch ($this->getAttribute('status_id')) {
            case 5:
            case 6:
                return $this->getAttribute('cost_distance');
                break;
            default:
                return $this->getAttribute('distanceCost');
        }
    }

    /**
     * Стоимлсть запчастей
     *
     * @return float
     */
    public function cost_parts()
    {
        return $this->parts()->count() == 0 ? 0 : $this->parts->sum('total');
    }

    public function getTotalDifficultyCostAttribute()
    {
        return $this->cost_difficulty();
    }

    public function getTotalDistanceCostAttribute()
    {
        return $this->cost_distance();
    }

    public function getTotalCostPartsAttribute()
    {
        return $this->cost_parts();
    }

    public function getTotalCostPartsEuroAttribute()
    {
        return $this->parts()->count() == 0 ? 0 : $this->parts->sum('TotalEuro');
    }

    public function getDifficultyCostAttribute()
    {
        return $this->difficulty->cost * Site::currencyRates($this->difficulty->currency, $this->user->currency);
    }

    public function getDistanceCostAttribute()
    {
        return $this->distance->cost * Site::currencyRates($this->distance->currency, $this->user->currency);
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
     * Серийный номер
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function serial()
    {
        return $this->belongsTo(Serial::class);
    }

    /**
     * Акт выполненных работ
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function act()
    {
        return $this->belongsTo(Act::class);
    }

    /**
     * Контрагент - исполнитель
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contragent()
    {
        return $this->belongsTo(Contragent::class);
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
     * Тариф на транспорт
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function distance()
    {
        return $this->belongsTo(Distance::class);
    }

    /**
     * Класс сложности
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function difficulty()
    {
        return $this->belongsTo(Difficulty::class);
    }

    /**
     * Оборудование
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

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
