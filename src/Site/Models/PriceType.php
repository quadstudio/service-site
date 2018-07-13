<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class PriceType extends Model
{

    /**
     * @var string
     */
    protected $table;

    public $incrementing = false;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'price_types';
    }

    /**
     * Валюта цены
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }


}
