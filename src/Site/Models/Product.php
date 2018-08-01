<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Facades\Site;

class Product extends Model
{

    public $incrementing = false;
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
     * Тип товара
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * Производитель
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function name()
    {
        $name = [
            $this->name,
            $this->brand->name
        ];
        if (mb_strlen($this->sku, 'UTF-8') > 0) {
            $name[] = "({$this->sku})";
        }

        return implode(' ', $name);
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

    public function toCart(){
        return [
            'product_id' => $this->id,
            'name' => $this->name,
            'price'=> $this->price()->price(),
            'currency_id'=> Site::currency()->id,
            'image' => $this->image()->src(),
            'brand_id' => $this->brand_id,
            'brand' => $this->brand->name,
            'weight' => $this->weight,
            'unit' => $this->unit,
            'sku' => $this->sku,
            'url' => route('products.show', $this),
            'availability' => $this->quantity > 0,
            'quantity' => 1
        ];
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
     * Документация
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function datasheets()
    {
        return $this->belongsToMany(
            Datasheet::class,
            env('DB_PREFIX', '') . 'datasheet_product',
            'product_id',
            'datasheet_id'
        );
    }

    public function price()
    {
        $type_id = Auth::guest() ? config('site.defaults.guest.price_type_id') : Auth::user()->price_type_id;
        $table = (new Price())->getTable();

        return $this
            ->prices()
            ->where($table . '.type_id', '=', $type_id)
            ->where($table . '.price', '<>', 0.00)
            ->firstOrNew([]);
    }

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
     * @return Model
     */
    public function image()
    {
        return $this->images()->firstOrNew([]);
    }

    /**
     * Изображения
     *
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function images()
    {
        if (config('site::cache.use', true) === true) {
            $key = $this->primaryKey;
            $cacheKey = 'product_images_' . $this->{$key};

            return cache()->remember($cacheKey, config('site::cache.ttl'), function () {
                return $this->_images();
            });
        }

        return $this->_images();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function _images()
    {
        return $this->morphMany(Image::class, 'imageable');
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
     * Прямые аналоги
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function analogs()
    {
        return $this->belongsToMany(
            Product::class,
            $this->prefix . 'analogs',
            'product_id',
            'analog_id');
    }

    /**
     * Обратные аналоги
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function back_analogs()
    {

        return $this->belongsToMany(
            Product::class,
            $this->prefix . 'analogs',
            'analog_id',
            'product_id');
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

    /**
     * @return \Illuminate\Support\Collection
     */
    public function relation_equipments()
    {

        $equipments = collect([]);
        foreach ($this->back_relations()->where('enabled', 1)->get() as $relation) {
            if (!is_null($relation->equipment_id)) {
                $equipments->put($relation->equipment_id, $relation->equipment);
            }
        }

        return $equipments;
    }


}
