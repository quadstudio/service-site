<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Concerns\Sortable;

class Element extends Model
{

    use Sortable;
    /**
     * @var string
     */
    protected $table = 'elements';
    /**
     * @var array
     */
    protected $fillable = [
        'product_id', 'number', 'sort_order'
    ];

    /**
     * Схема
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function scheme()
    {
        return $this->belongsTo(Scheme::class);
    }

    /**
     * Деталь (Товар)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Указатели
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pointers()
    {
        return $this->hasMany(Pointer::class);
    }
    /**
     * Контуры
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function shapes()
    {
        return $this->hasMany(Shape::class);
    }

}
