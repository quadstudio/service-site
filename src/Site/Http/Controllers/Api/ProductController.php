<?php

namespace QuadStudio\Service\Site\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\Product\MountingFilter;
use QuadStudio\Service\Site\Filters\Product\ProductSearchFilter;
use QuadStudio\Service\Site\Filters\Product\SearchFilter;
use QuadStudio\Service\Site\Filters\ProductCanBuyFilter;
use QuadStudio\Service\Site\Filters\Product\LimitFilter;
use QuadStudio\Service\Site\Http\Resources\ProductCollection;
use QuadStudio\Service\Site\Models\Product;
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
    public function fast()
    {
        $this->products->applyFilter(new ProductCanBuyFilter());
        $this->products->applyFilter(new SearchFilter());
        $this->products->applyFilter(new LimitFilter());

        return new ProductCollection($this->products->all());
    }

    /**
     * @param Product $product
     * @return \Illuminate\View\View
     */
    public function part(Product $product)
    {
        return view('site::part.card', collect([
            'product_id' => $product->id,
            'sku'        => $product->sku,
            'image'      => $product->image()->src(),
            'cost'       => $product->hasPrice ? $product->repairPrice->value : 0,
            'format'     => $product->hasPrice ? Site::format($product->repairPrice->value): trans('site::price.error.price'),
            'name'       => $product->name,
            'count'      => 1,
        ]));
    }
}