<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    /**
     * @var string
     */
    protected $table;
    /**
     * @var array
     */
    protected $fillable = [
        'block_id', 'datasheet_id', 'image_id'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'schemes';
    }

    /**
     * Блок
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    /**
     * Файл взрывной схемы (каталог запчастей в техдокументации)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function datasheet()
    {
        return $this->belongsTo(Datasheet::class);
    }

    /**
     * Изображение схемы
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * @param $product
     * @return $this
     */
    public function attachProduct($product)
    {
        if ($product instanceof Product) {
            $product = $product->getKey();
        }
        if (is_array($product)) {
            return $this->attachProducts($product);
        }
        $this->products()->attach($product);

        return $this;
    }

    /**
     * @param array $products
     * @return $this
     */
    public function attachProducts(array $products)
    {
        foreach ($products as $product) {
            $this->attachProduct($product);
        }

        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        if (config('site::cache.use', true) === true) {
            $key = $this->primaryKey;
            $cacheKey = 'product_scheme_' . $this->{$key};

            return cache()->remember($cacheKey, config('site::cache.ttl'), function () {
                return $this->_products();
            });
        }

        return $this->_products();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function _products()
    {
        return $this->belongsToMany(
            Product::class,
            'product_scheme',
            'scheme_id',
            'product_id'
        );
    }

    /**
     * Детали схемы
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elements()
    {
        return $this->hasMany(Element::class);
    }

}
