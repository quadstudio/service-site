<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class PriceType extends Model
{

    /**
     * @var string
     */
    protected $table = 'price_types';

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['display_name'];

    /**
     * Валюта цены
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Цены
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prices()
    {
        return $this->hasMany(Price::class, 'type_id');
    }


}
