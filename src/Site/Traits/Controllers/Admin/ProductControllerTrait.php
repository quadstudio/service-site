<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Http\Requests\Admin\ProductRequest;
use QuadStudio\Service\Site\Http\Requests\ImageRequest;
use QuadStudio\Service\Site\Jobs\ProcessImage;
use QuadStudio\Service\Site\Models\Image;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Repositories\ProductRepository as Repository;

trait ProductControllerTrait
{

    protected $products;

    /**
     * Create a new controller instance.
     *
     * @param Repository $products
     */
    public function __construct(Repository $products)
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

        return view('site::admin.product.index', [
            'repository' => $this->products,
            'products'   => $this->products->paginate(config('site.per_page.product', 12), [env('DB_PREFIX', '') . 'products.*'])
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
        return view('site::admin.product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('site::admin.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductRequest $request
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $this->products->update($request->only(['enabled', 'active', 'warranty', 'service']), $product->id);

        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('admin.products.edit', $product)->with('success', trans('site::product.updated'));
        } else {
            $redirect = redirect()->route('admin.products.show', $product)->with('success', trans('site::product.updated'));
        }

        return $redirect;
    }

}