<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{

    protected $fillable = ['name', 'description'];

    /**
     * Товары
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'type_id');
    }


}
