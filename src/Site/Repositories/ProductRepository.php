<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\PartSearchFilter;
use QuadStudio\Service\Site\Filters\Product\TypeFilter;
use QuadStudio\Service\Site\Filters\ProductSortFilter;
use QuadStudio\Service\Site\Models\Product;

class ProductRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Product::class;
    }

    /**
     * @return array
     */
    public function track():array
    {
        return [
            PartSearchFilter::class,
            TypeFilter::class,
            ProductSortFilter::class,
        ];
    }
}