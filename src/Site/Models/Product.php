<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Contracts\Imageable;
use QuadStudio\Service\Site\Facades\Site;
use QuadStudio\Service\Site\Concerns\AttachAnalogs;
use QuadStudio\Service\Site\Concerns\AttachDetails;
use QuadStudio\Service\Site\Concerns\AttachRelations;

class Product extends Model implements Imageable
{
    use AttachAnalogs, AttachDetails, AttachRelations;
    /**
     * @var bool
     */
    public $incrementing = false;
    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'sku', 'old_sku', 'enabled',
        'show_ferroli', 'show_lamborghini',
        'warranty', 'service', 'description',
        'h1', 'title', 'metadescription',
        'specification', 'equipment_id', 'type_id'
    ];

    protected $casts = [

        'name'             => 'string',
        'sku'              => 'string',
        'old_sku'          => 'string',
        'h1'               => 'string',
        'title'            => 'string',
        'metadescription'  => 'string',
        'specification'    => 'string',
        'enabled'          => 'boolean',
        'show_ferroli'     => 'boolean',
        'show_lamborghini' => 'boolean',
        'warranty'         => 'boolean',
        'service'          => 'boolean',
        'equipment_id'     => 'integer',
        'type_id'          => 'integer',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'products';
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
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param null $product_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMounted($query, $product_id = null)
    {
        $query
            ->whereNotNull('sku')
            ->where('enabled', 1)
            ->where('type_id', 1);
        if (!is_null($product_id)) {
            $query->where('id', $product_id);
        }

        return $query;
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

    public function getFullNameAttribute()
    {
        $name = [];
        if (mb_strlen($this->getAttribute('name'), 'UTF-8') > 0) {
            $name[] = $this->getAttribute('name');
        }
        if (mb_strlen($this->getAttribute('sku'), 'UTF-8') > 0) {
            $name[] = "({$this->getAttribute('sku')})";
        }

        return !empty($name) ? implode(' ', $name) : $this->getAttribute('id');
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

    public function getNameAttribute($name)
    {
        $name = str_replace('&rsquo;', "'", $name);
        $name = str_replace('&rdquo;', '"', $name);
        $name = str_replace('&lt;', '<', $name);
        $name = str_replace('&gt;', '>', $name);
        $name = str_replace('&frasl;', '/', $name);
        $name = str_replace('&ndash;', '-', $name);

        return $name;
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
            return new Image([
                'src'     => storage_path('app/public/images/products/noimage.png'),
                'storage' => 'products'
            ]);
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
        return $this->morphMany(Image::class, 'imageable');
//        if (config('site::cache.use', true) === true) {
//            $key = $this->primaryKey;
//            $cacheKey = 'product_images_' . $this->{$key};
//
//            return cache()->remember($cacheKey, config('site::cache.ttl'), function () {
//                return $this->_images();
//            });
//        }
//
//        return $this->_images();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\morphMany
     */
    public function _images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Получить тип цены для отчета по ремонту
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getRepairPriceTypeAttribute()
    {
        return Auth::guest()
            ? config('site.defaults.guest.price_type_id')
            : config('site.defaults.part.price_type_id', config('site.defaults.user.price_type_id'));
    }

    /**
     * @return Model
     */
    public function getRepairPriceAttribute()
    {
        return $this
            ->getRepairPrice()
            ->firstOrNew([]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    private function getRepairPrice()
    {
        return $this
            ->prices()
            ->where('type_id', '=', $this->repairPriceType)
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

    /**
     * Премия за отчет по монтажу
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function mounting_bonus()
    {
        return $this->hasOne(MountingBonus::class);
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getPriceTypeAttribute()
    {
        return Auth::guest()
            ? config('site.defaults.guest.price_type_id')
            : (
            (
            $user_price = Auth::user()->prices()->where('product_type_id', $this->type_id))->exists()
                ? $user_price->first()->price_type_id
                : config('site.defaults.user.price_type_id')
            );
    }

    /**
     * @return Model
     */
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

        //dd($this->priceType);
        return $this
            ->prices()
            ->where('type_id', '=', $this->priceType)
            ->where('price', '<>', 0.00);
    }

    /**
     * @return bool
     */
    public function getHasPriceAttribute()
    {
        return $this->getPrice()->exists();
    }

    /**
     * @return bool
     */
    public function getCanBuyAttribute()
    {
        return $this->getAttribute('active') == 1
            && $this->getAttribute('enabled') == 1
            && $this->getAttribute('service') == 0;
        //return $this->hasPrice && $this->getAttribute('active') == 1;
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
            'datasheet_product',
            'product_id',
            'datasheet_id'
        );
    }

    /**
     * Взрывные схемы
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function schemes()
    {
        return $this->belongsToMany(
            Scheme::class,
            'product_scheme',
            'product_id',
            'scheme_id'
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
     * Отчеты по ремонту
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function repairs()
    {
        return $this->hasMany(Repair::class, 'product_id');
    }

    /**
     * Отчеты по монтажу
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mountings()
    {
        return $this->hasMany(Mounting::class);
    }

    public function hasSku()
    {
        return !is_null($this->getAttribute('sku'));
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
     * Товар является аналогом для
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function back_analogs()
    {
        return $this->belongsToMany(
            Product::class,
            'analogs',
            'analog_id',
            'product_id');
    }

    public function hasEquipment()
    {
        return !is_null($this->getAttribute('equipment_id'));
    }

}
