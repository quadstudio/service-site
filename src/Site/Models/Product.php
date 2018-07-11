<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{

    /**
     * @var string
     */
    protected $table;
    protected $prefix;
    private $_price;

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->prefix = env('DB_PREFIX', '');
        $this->table = $this->prefix . 'products';
    }

    /**
     * Product type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Price
     */
    public function price()
    {
        $type_id = Auth::guest() ? config('shop.default_price_type') : Auth::user()->profile->price_type_id;
        $price = $this->prices()->where('type_id', '=', $type_id)->first();
        return is_null($price) ? new Price() : $price;
    }

    /**
     * Product prices
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prices()
    {
        return $this->hasMany(Price::class);
    }


}
