<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\ProductCanBuyFilter;
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
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->products->trackFilter();
        $this->products->applyFilter(new ProductCanBuyFilter());
        return view('site::product.index', [
            'repository' => $this->products,
            'items' => $this->products->paginate(config('shop.per_page.product', 8))
        ]);
    }

    /**
     * Show the product page
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('site::product.show', compact('product'));
    }

}