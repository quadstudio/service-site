<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{

    /**
     * @var string
     */
    protected $table;
    /**
     * @var array
     */
    protected $fillable = [
        'path', 'name', 'mime', 'size', 'sort_order', 'storage'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'images';
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($image) {
            Storage::disk($image->storage)->delete($image->path);
        });
    }

    public function src()
    {
        if (!$this->exists || !Storage::disk($this->storage)->has($this->path)) {
            return Storage::disk($this->storage)->url('noimage.png');
        } else {
            return Storage::disk($this->storage)->url($this->path);
        }
    }

    /**
     * Get all of the owning contactable models.
     */
    public function imageable()
    {
        return $this->morphTo();
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
