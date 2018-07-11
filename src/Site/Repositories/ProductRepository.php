<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\ProductSearchFilter;
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
            ProductSortFilter::class,
            ProductSearchFilter::class,
        ];
    }
}