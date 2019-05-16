<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Concerns\Sortable;
use QuadStudio\Service\Site\Contracts\Imageable;

class Equipment extends Model implements Imageable
{

    use Sortable;
    /**
     * @var string
     */
    protected $table;

    protected $fillable = [
        'name', 'annotation', 'description',
        'h1', 'title', 'metadescription',
        'specification', 'catalog_id', 'sort_order',
        'enabled', 'show_ferroli', 'show_lamborghini'
    ];

    protected $casts = [

        'name'             => 'string',
        'annotation'       => 'string',
        'description'      => 'string',
        'h1'               => 'string',
        'title'            => 'string',
        'metadescription'  => 'string',
        'specification'    => 'string',
        'catalog_id'       => 'integer',
        'sort_order'       => 'integer',
        'enabled'          => 'boolean',
        'show_ferroli'     => 'boolean',
        'show_lamborghini' => 'boolean',
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
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    private function _products()
    {

    }

    public function canDelete()
    {
        return $this->products->isEmpty();
    }

}
