<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\ProductHasImageFilter;
use QuadStudio\Service\Site\Filters\ProductHasPriceFilter;
use QuadStudio\Service\Site\Filters\ProductNotZeroPriceFilter;
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
        if(config('shop.hide_zero_price', true) === true){
            $this->products->pushFilter(new ProductNotZeroPriceFilter());
        } elseif(config('shop.hide_without_price', true) === true){
            $this->products->pushFilter(new ProductHasPriceFilter());
        }

        if(config('shop.hide_no_image', true) === true){
            $this->products->pushFilter(new ProductHasImageFilter());
        }

        return view('product.index', [
            'repository' => $this->products,
            'items' => $this->products->paginate(config('shop.per_page.product', 8))
        ]);
    }

    /**
     * Show the product page
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('product.show');
    }

}