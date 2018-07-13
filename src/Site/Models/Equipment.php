<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'name', 'description'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'equipments';
    }

    /**
     * Каталог
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    /**
     * Валюта расценок
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

}
