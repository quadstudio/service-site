<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;


use QuadStudio\Service\Site\Filters\Product\DatasheetFilter;
use QuadStudio\Service\Site\Http\Resources\ProductCollection;
use QuadStudio\Service\Site\Repositories\ProductRepository;

trait DatasheetControllerTrait
{

    protected $products;

    /**
     * Create a new controller instance.
     *
     * @param ProductRepository $products
     */
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    /**
     * @return ProductCollection
     */
    public function products()
    {
        $this->products->applyFilter(new DatasheetFilter());

        return new ProductCollection($this->products->all());
    }

}