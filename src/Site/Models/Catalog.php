<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use QuadStudio\Service\Site\Models\Product;

class Catalog extends Model
{

    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'name_plural', 'description',
        'catalog_id', 'enabled', 'model'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'catalogs';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function catalog()
    {
        return $this->belongsTo(Catalog::class);//, 'id', 'catalog_id'
    }

    /**
     * Изображения
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        if (config('site::cache.use', true) === true) {
            $key = $this->primaryKey;
            $cacheKey = 'equipment_catalog_images_' . $this->{$key};

            return cache()->remember($cacheKey, config('site::cache.ttl'), function () {
                return $this->_images();
            });
        }

        return $this->_images();
    }

    public function _images()
    {
        return $this->hasMany(CatalogImage::class);
    }

    /**
     * @return bool
     */
    public function canDelete()
    {
        return
            //Нет дочерних элементов
            $this->has('catalogs')->get()->isEmpty() &&
            // и
            // Нет прикрепленных товаров
            $this->has('products')->get()->isEmpty();
    }

    public function parentTreeName()
    {
        $name = [];
        $last = null;
        $this->parentTree()->reverse()->each(function ($item, $key) use (&$name, &$last) {
            if ($item->catalogs->count() > 0) {
                $name[] = mb_strtolower($item->name, 'UTF-8');
            } else {
                $last = ' ' . $item->name;
            }
        });
        $name = implode(' ', $name);

        return mb_strtoupper(mb_substr($name, 0, 1)) . mb_substr($name, 1) . $last;

    }

    /**
     * @return Collection
     */
    public function parentTree()
    {
        $tree = collect([]);
        if (config('site::cache.use', true) === true) {
            $key = $this->primaryKey;
            $cacheKey = 'equipment_catalog_parentTree_' . $this->{$key};

            return cache()->remember($cacheKey, config('site::cache.ttl'), function () use ($tree) {
                return $this->_parentTree($this, $tree);
            });
        }
        return $this->_parentTree($this, $tree);
    }


    /**
     * @param Catalog $catalog
     * @param Collection $tree
     * @return Collection
     */
    private function _parentTree(Catalog $catalog, Collection &$tree)
    {
        $tree->push($catalog);
        if (!is_null($catalog->catalog)) {
            $this->_parentTree($catalog->catalog, $tree);
        }
        return $tree;
    }

    /**
     * @return bool
     */
    public function canAddProduct()
    {
        return $this->model == 1;
    }

    /**
     * @return bool
     */
    public function isRoot()
    {
        return is_null($this->catalog_id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|mixed
     */
    public function catalogs()
    {
        if (config('site::cache.use', true) === true) {
            $key = $this->primaryKey;
            $cacheKey = 'equipment_catalog_catalogs_' . $this->{$key};

            return cache()->remember($cacheKey, config('site::cache.ttl'), function () {
                return $this->_catalogs();
            });
        }

        return $this->_catalogs();

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function _catalogs()
    {
        return $this->hasMany(Catalog::class);
    }

    public function canAddCatalog()
    {
        return $this->model == 0;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        if (config('site::cache.use', true) === true) {
            $key = $this->primaryKey;
            $cacheKey = 'equipment_catalog_products_' . $this->{$key};

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
        return $this->hasMany(Product::class)->where('equipment', 1);
    }


}
