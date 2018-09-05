<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;
use QuadStudio\Service\Site\Traits\Models\SortOrderTrait;

class Element extends Model
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
        'product_id', 'scheme_id', 'number', 'sort_order'
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = env('DB_PREFIX', '') . 'elements';
    }

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
