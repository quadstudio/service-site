<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Analog extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'product_id', 'analog_id', 'ratio'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', ''). 'analogs';
    }

    /**
     * Оригигал
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Аналог
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function analog()
    {
        return $this->belongsTo(Product::class, 'analog_id');
    }

}
