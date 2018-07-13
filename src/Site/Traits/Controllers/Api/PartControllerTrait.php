<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;

use QuadStudio\Service\Site\Filters\PartSearchFilter;
use QuadStudio\Service\Site\Filters\PartSerialSearchFilter;
use QuadStudio\Service\Site\Http\Resources\PartCollection;
use QuadStudio\Service\Site\Http\Resources\PartResource;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Repositories\ProductRepository;

trait PartControllerTrait
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
     * @return PartCollection
     */
    public function index()
    {
        $this->products->applyFilter(new PartSearchFilter());
        $this->products->applyFilter(new PartSerialSearchFilter());

        return new PartCollection($this->products->all());
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return PartResource
     */
    public function show(Product $product)
    {
        return new PartResource($product);
    }
}