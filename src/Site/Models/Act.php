<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Concerns\Schedulable;

class Act extends Model
{

    use Schedulable;

    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'number', 'contragent_id',
        'received', 'paid', 'type_id'
    ];

    protected $casts = [

        'number'        => 'string',
        'guid'          => 'string',
        'contragent_id' => 'integer',
        'received'      => 'boolean',
        'paid'          => 'boolean',
        'type_id'       => 'integer',
    ];

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
     * Тип акта
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ActType::class);
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contents()
    {
        $contents = $this->type->alias;

        return $this->$contents();
    }

    /**
     * Отчеты по монтажу
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mountings()
    {
        return $this->hasMany(Mounting::class);
    }

    /**
     * Стоимость акта
     *
     * @return float
     */
    public function getTotalAttribute()
    {
        return $this->getAttribute('total_' . $this->type->alias);
    }

    public function getTotalRepairsAttribute()
    {
        return $this->repairs->sum('total_difficulty_cost')
            + $this->repairs->sum('total_distance_cost')
            + $this->repairs->sum('total_cost_parts');
    }

    public function getTotalMountingsAttribute()
    {
        return $this->mountings->sum('bonus')
            + $this->mountings->sum('enabled_social_bonus');
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
