<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    protected $fillable = [
        'product_id', 'name', 'quantity', 'price',
        'currency_id', 'sku', 'weight', 'brand_id', 'unit',
        'type_id', 'service', 'availability'
    ];

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

    /**
     * @return string
     */
    public function name()
    {
        $result = [];
        $result[] = $this->name;
        if (mb_strlen($this->sku, "UTF-8") > 0) {
            $result[] = '(' . $this->sku . ')';
        }

        return htmlspecialchars_decode(implode(' ', $result));
    }


}
