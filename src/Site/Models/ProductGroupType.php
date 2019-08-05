<?php

namespace QuadStudio\Service\Site\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGroupType extends Model
{
    /**
     * @var string
     */
    protected $table;

    protected $fillable = ['name', 'title', 'icon', 'check_cart'];

    protected $casts = [
        'name'       => 'string',
        'icon'       => 'string',
        'title'      => 'string',
        'check_cart' => 'boolean',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'product_group_types';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productGroups()
    {
        return $this->hasMany(ProductGroup::class, 'group_id');
    }
}
