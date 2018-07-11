<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CatalogImage extends Model
{

    /**
     * @var string
     */
    protected $table;
    /**
     * @var array
     */
    protected $fillable = [
        'path', 'name', 'mime', 'size', 'sort_order'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'catalog_images';
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            Storage::disk('equipment')->delete($model->path);
        });
    }

    /**
     * Элемент каталога
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }

    public function canDelete()
    {
        return true;
    }

}
