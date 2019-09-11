<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class StorehouseProduct extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['product_id', 'quantity'];

    /**
     * @var bool
     */
    protected $casts = [
        'product_id' => 'string',
        'quantity' => 'integer',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function storehouse()
    {
        return $this->belongsTo(Storehouse::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
