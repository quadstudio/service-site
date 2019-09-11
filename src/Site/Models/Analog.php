<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Analog extends Model
{
    /**
     * @var string
     */
    protected $table = 'analogs';

    protected $fillable = [
        'product_id', 'analog_id', 'ratio'
    ];

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
