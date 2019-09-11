<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGroupType extends Model
{
    /**
     * @var string
     */
    protected $table = 'product_group_types';

    protected $fillable = ['name', 'title', 'icon', 'check_cart'];

    protected $casts = [
        'name'       => 'string',
        'icon'       => 'string',
        'title'      => 'string',
        'check_cart' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productGroups()
    {
        return $this->hasMany(ProductGroup::class, 'group_id');
    }
}
