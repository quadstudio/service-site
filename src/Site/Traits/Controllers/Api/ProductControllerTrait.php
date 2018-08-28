<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;

use QuadStudio\Service\Site\Filters\Product\BoilerSearchFilter;
use QuadStudio\Service\Site\Filters\Product\LimitFilter;
use QuadStudio\Service\Site\Filters\Product\SearchFilter;
use QuadStudio\Service\Site\Filters\Product\ProductSearchFilter;
use QuadStudio\Service\Site\Filters\ProductCanBuyFilter;
use QuadStudio\Service\Site\Http\Resources\ProductCollection;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Repositories\ProductRepository;

trait ProductControllerTrait
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
    public function index()
    {
        $this->products->applyFilter(new SearchFilter());
        $this->products->applyFilter(new ProductSearchFilter());
        return new ProductCollection($this->products->all());
    }

    /**
     * @return ProductCollection
     */
    public function repair()
    {
        $this->products->applyFilter(new SearchFilter());
        $this->products->applyFilter(new ProductSearchFilter());
        return new ProductCollection($this->products->all());
    }

    /**
     * @return ProductCollection
     */
    public function analog()
    {
        $this->products->applyFilter(new SearchFilter());
        return new ProductCollection($this->products->all());
    }

    /**
     * @return ProductCollection
     */
    public function fast()
    {
        $this->products->applyFilter(new ProductCanBuyFilter());
        $this->products->applyFilter(new SearchFilter());
        $this->products->applyFilter(new LimitFilter());

        return new ProductCollection($this->products->all());
    }
    /**
     * @return ProductCollection
     */
    public function product()
    {
        $this->products->applyFilter(new BoilerSearchFilter());
        return new ProductCollection($this->products->all());
    }

    /**
     * @return ProductCollection
     */
    public function relation()
    {
        $this->products->applyFilter(new SearchFilter());
        return new ProductCollection($this->products->all());
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Product $product)
    {
        return view('site::part.repair.row', collect([
            'product_id' => $product->id,
            'sku' => $product->sku,
            'image' => $product->image()->src(),
            'cost' => $product->price()->exists ? $product->price()->price() : '',
            'format' => $product->price()->exists ? $product->price()->format() : '',
            'name' => $product->name,
            'count' => 1,
        ]));
    }

}