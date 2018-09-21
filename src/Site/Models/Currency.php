<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{

    protected $fillable = [
        'name', 'title', 'rates', 'multiplicity',
    ];

    /**
     * @var string
     */
    protected $table;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'currencies';
    }

    /**
     * История курсов
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function archives()
    {
        return $this->hasMany(CurrencyArchive::class);
    }

}
