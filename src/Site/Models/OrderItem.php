<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Currency\Models\Currency;

class OrderItem extends Model
{

    /**
     * @var string
     */
    protected $table;

    protected $fillable = ['product_id', 'name', 'quantity', 'price','currency_id', 'sku', 'manufacturer', 'unit', 'weight', 'image', 'url', 'is_service', 'availability', 'properties'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'order_items';
    }

    /**
     * @return mixed
     */
    public function subtotal()
    {
        return $this->price * $this->quantity;
    }

    /**
     * Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Currency
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }


}
