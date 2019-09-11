<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyArchive extends Model
{

    /**
     * @var string
     */
    protected $table = 'currency_archives';

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
     * Валюта
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

}
