<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
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
    protected $fillable = [
        'enabled', 'active', 'warranty', 'service', 'description', 'equipment_id'
    ];

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
        return $this->belongsTo(Brand::class)->withDefault(function ($brand) {
            $brand->name = '';
        });
    }

    public function name()
    {
        $name = [];
        if (mb_strlen($this->sku, 'UTF-8') > 0) {
            $name[] = "{$this->sku}";
        }
        if (mb_strlen($this->name, 'UTF-8') > 0) {
            $name[] = $this->name;
        }


        return !empty($name) ? implode(' &bull; ', $name) : $this->id;
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

    public function toCart()
    {
        return [
            'product_id'   => $this->id,
            'sku'          => $this->sku,
            'name'         => $this->name,
            'type'         => $this->type->name,
            'unit'         => $this->unit,
            'price'        => $this->hasPrice ? $this->price->value : null,
            'format'       => Site::format($this->price->value),
            'currency_id'  => Site::currency()->id,
            'url'          => route('products.show', $this),
            'image'        => $this->image()->src(),
            'availability' => $this->quantity > 0,
            'service'      => $this->service == 1,
        ];
    }

    /**
     * @return Model|\Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function image()
    {
        if ($this->images()->count() == 0) {
            return new Image(['src' => storage_path('app/public/images/products/noimage.png')]);
        }

        return $this->images()->first();
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

    public function getPriceTypeAttribute()
    {
        return Auth::guest() ? config('site.defaults.guest.price_type_id') : Auth::user()->price_type_id;
    }



//    public function price()
//    {
//        return $this
//            ->prices()
//            ->where('prices.type_id', '=', Auth::guest() ? config('site.defaults.guest.price_type_id') : Auth::user()->price_type_id)
//            ->where('prices.price', '<>', 0.00)
//            ->firstOrNew([]);
//    }

    public function getPriceAttribute()
    {
        return $this
            ->getPrice()
            ->firstOrNew([]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    private function getPrice()
    {
        return $this
            ->prices()
            ->where('type_id', '=', $this->priceType)
            ->where('price', '<>', 0.00);
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

    public function getHasPriceAttribute()
    {
        return $this->getPrice()->exists();
    }

    public function getCanBuyAttribute()
    {
        return $this->hasPrice && $this->getAttribute('active') == 1;
    }

    public function created_at($time = false)
    {
        return !is_null($this->created_at) ? Carbon::instance($this->created_at)->format('d.m.Y' . ($time === true ? ' H:i' : '')) : '';
    }

    public function updated_at($time = false)
    {
        return !is_null($this->updated_at) ? Carbon::instance($this->updated_at)->format('d.m.Y' . ($time === true ? ' H:i' : '')) : '';
    }

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

    /**
     * Позиции в заказе
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
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
     * Добавить аналог
     *
     * @param mixed $analog
     */
    public function attachAnalog($analog)
    {
        if (is_object($analog)) {
            $analog = $analog->getKey();
        }
        if (is_array($analog)) {
            $analog = $analog['id'];
        }
        $this->analogs()->attach($analog);
    }

    /**
     * Аналоги товара
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
     * Удалить аналог
     *
     * @param mixed $analog
     */
    public function detachAnalog($analog)
    {
        if (is_object($analog)) {
            $analog = $analog->getKey();
        }
        if (is_array($analog)) {
            $analog = $analog['id'];
        }
        $this->analogs()->detach($analog);
    }

    /**
     * @param $image_id
     * @return $this
     */
    public function detachImage($image_id)
    {
        Image::query()->findOrNew($image_id)->delete();

        return $this;
    }

    /**
     * Добавить связь оборудование - запчасть
     *
     * @param mixed $relation
     */
    public function attachRelation($relation)
    {
        if (is_object($relation)) {
            $relation = $relation->getKey();
        }
        if (is_array($relation)) {
            $relation = $relation['id'];
        }
        $this->relations()->attach($relation);
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
     * Удалить связь оборудование - запчасть
     *
     * @param mixed $relation
     */
    public function detachRelation($relation)
    {
        if (is_object($relation)) {
            $relation = $relation->getKey();
        }
        if (is_array($relation)) {
            $relation = $relation['id'];
        }
        $this->relations()->detach($relation);
    }

    /**
     * Товар является аналогом для
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

    public function hasEquipment()
    {
        return !is_null($this->getAttribute('equipment_id'));
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
