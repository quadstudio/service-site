<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;

use QuadStudio\Service\Site\Filters\Product\BoilerSearchFilter;
use QuadStudio\Service\Site\Http\Resources\BoilerCollection;
use QuadStudio\Service\Site\Http\Resources\BoilerResource;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Repositories\ProductRepository;

trait BoilerControllerTrait
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
     * @return BoilerCollection
     */
    public function index()
    {
        $this->products->trackFilter();
        $this->products->pushTrackFilter(BoilerSearchFilter::class);
        return new BoilerCollection($this->products->all());
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return BoilerResource
     */
    public function show(Product $product)
    {
        return $product->hasEquipment() ? new BoilerResource($product) : response('', 404);
    }

//    public function repair(){
//        return view('site::part.repair.row', collect([
//            'product_id' => $product->id,
//            'sku' => $product->sku,
//            'image' => $product->image()->src(),
//            'cost' => $product->price()->exists ? $product->price()->price() : '',
//            'format' => $product->price()->exists ? $product->price()->format() : '',
//            'name' => $product->name,
//            'count' => 1,
//        ]));
//    }

}