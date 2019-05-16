<?php

namespace QuadStudio\Service\Site\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\Product\ProductSearchFilter;
use QuadStudio\Service\Site\Filters\Product\SearchFilter;
use QuadStudio\Service\Site\Http\Resources\ProductCollection;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Repositories\ProductRepository;

class PartController extends Controller
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
     * @param Product $product
     * @return \Illuminate\View\View
     */
    public function create(Product $product)
    {
        return view('site::part.create', compact('product'));
    }
}