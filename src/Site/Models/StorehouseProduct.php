<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class StorehouseProduct extends Model
{
    /**
     * @var string
     */
    protected $table;
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
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'storehouse_products';
    }

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
