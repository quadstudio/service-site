<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyArchive extends Model
{

    /**
     * @var string
     */
    protected $table;

    protected $fillable = ['currency_id', 'date', 'rates', 'multiplicity'];

    protected $casts = [


        'currency_id'  => 'integer',
        'date'         => 'date:Y-m-d',
        'rates'        => 'decimal',
        'multiplicity' => 'integer',

    ];

    protected $dates = [
        'date'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'currency_archives';
    }

    /**
     * Валюта
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

}
