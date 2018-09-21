<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Traits\Models\SortOrderTrait;

class Equipment extends Model
{

    use SortOrderTrait;
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'name',  'annotation', 'description', 'enabled', 'catalog_id', 'sort_order'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'equipments';
    }

    public function detachImages()
    {
        foreach ($this->images as $image) {
            $image->imageable_id = null;
            $image->imageable_type = null;
            $image->save();
        }
    }

    /**
     * Каталог
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

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
            $cacheKey = 'equipment_images_' . $this->{$key};

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        if (config('site::cache.use', true) === true) {
            $key = $this->primaryKey;
            $cacheKey = 'equipment_products_' . $this->{$key};

            return cache()->remember($cacheKey, config('site::cache.ttl'), function () {
                return $this->_products();
            });
        }

        return $this->_products();

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    private function _products()
    {
        return $this->hasMany(Product::class);
    }

    public function canDelete()
    {
        return $this->products->isEmpty();
    }

}
