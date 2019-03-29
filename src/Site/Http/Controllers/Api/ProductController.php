<?php

namespace QuadStudio\Service\Site\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\Product\MountingFilter;
use QuadStudio\Service\Site\Filters\Product\SearchFilter;
use QuadStudio\Service\Site\Http\Resources\ProductCollection;
use QuadStudio\Service\Site\Repositories\ProductRepository;

class ProductController extends Controller
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

    public function mounting()
    {
        $this->products->applyFilter(new MountingFilter());
        $this->products->applyFilter(new SearchFilter());

        return new ProductCollection($this->products->all());
    }
}