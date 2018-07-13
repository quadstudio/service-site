<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    /**
     * @var string
     */
    protected $table;
    protected $prefix;
    private $_price;

    public $incrementing = false;

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
     * Тип товара
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * Модель
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Price
     */
//    public function price()
//    {
//        $type_id = Auth::guest() ? config('shop.default_price_type') : Auth::user()->profile->price_type_id;
//        $price = $this->prices()->where('type_id', '=', $type_id)->first();
//        return is_null($price) ? new Price() : $price;
//    }

    /**
     * Цены
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    /**
     * Серийные номера
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function serials()
    {
        return $this->hasMany(Serial::class);
    }

    /**
     * Прямая связь товаров
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function relations()
    {
        return $this->belongsToMany(
            Product::class,
            $this->prefix . 'relations',
            'product_id',
            'relation_id');
    }

    /**
     * Обрантая связь товаров
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function back_relations()
    {
        return $this->belongsToMany(
            Product::class,
            $this->prefix . 'relations',
            'relation_id',
            'product_id');
    }


}
