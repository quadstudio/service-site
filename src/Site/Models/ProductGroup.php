<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{

    protected $fillable = ['id', 'name', 'type_id'];

    /**
     * Товары
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'group_id');
    }

    /**
     * Тип группы товара
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(ProductGroupType::class, 'type_id');
    }
}
