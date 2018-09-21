<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Traits\Models\ScheduleTrait;

class Act extends Model
{

    use ScheduleTrait;

    /**
     * @var string
     */
    protected $table;

    protected $fillable = ['number', 'contragent_id'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'acts';
    }

    /**
     * Реквизиты
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(ActDetail::class);
    }

    /**
     * Сервисный центр
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Организация
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Контрагент
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contragent()
    {
        return $this->belongsTo(Contragent::class);
    }

    /**
     * Отчеты по ремонту
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }

    /**
     * Стоимость работ
     *
     * @return float
     */
    public function getDifficultyCostAttribute()
    {
        return $this->repairs->sum('total_difficulty_cost');
    }

    /**
     * Стоимость дороги
     *
     * @return float
     */
    public function getDistanceCostAttribute()
    {
        return $this->repairs->sum('total_distance_cost');
    }

    /**
     * Стоимость запчастей
     *
     * @return float
     */
    public function getCostPartsAttribute()
    {
        return $this->repairs->sum('total_cost_parts');
    }

    /**
     * Стоимость запчастей
     *
     * @return float
     */
    public function getTotalAttribute()
    {
        return $this->getAttribute('difficulty_cost') + $this->getAttribute('distance_cost') + $this->getAttribute('cost_parts');
    }

    /**
     * @return string
     */
    public function number()
    {
        return !is_null($this->getAttribute('number')) ? $this->getAttribute('number') : $this->getKey();
    }

    /**
     * Scope a query to only opened acts
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
//    public function scopeOpened($query)
//    {
//        return $query->where('opened', 1);
//    }

}
