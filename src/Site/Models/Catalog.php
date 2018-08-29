<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use QuadStudio\Service\Site\Traits\Models\SortOrderTrait;

class Catalog extends Model
{

    use SortOrderTrait;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'name_plural', 'description',
        'catalog_id', 'enabled', 'model', 'sort_order'
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
     * Изображение каталога
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function catalog()
    {
        return $this->belongsTo(Catalog::class);//, 'id', 'catalog_id'
    }

    /**
     * @return bool
     */
    public function canDelete()
    {
        return
            //Нет дочерних элементов
            $this->catalogs()->count() == 0 &&
            // и
            // Нет прикрепленных товаров
            $this->equipments()->count() == 0;
    }

    public function parentTreeName()
    {
        $name = [];
        $last = null;
        $this->parentTree()->reverse()->each(function ($item, $key) use (&$name, &$last) {
            $name[] = mb_strtolower($item->name, 'UTF-8');
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

    public function parentRoot()
    {
        return $this->parentTree()->last();
    }

    /**
     * @return bool
     */
    public function canAddEquipment()
    {

        return $this->catalogs->isEmpty();
    }

    /**
     * @return mixed
     */
    public function canAddCatalog()
    {
        return $this->equipments->isEmpty();
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

    public function equipments()
    {
        if (config('site::cache.use', true) === true) {
            $key = $this->primaryKey;
            $cacheKey = 'equipment_catalog_equipments_' . $this->{$key};

            return cache()->remember($cacheKey, config('site::cache.ttl'), function () {
                return $this->_equipments();
            });
        }

        return $this->_equipments();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function _equipments()
    {
        return $this->hasMany(Equipment::class);
    }


}
