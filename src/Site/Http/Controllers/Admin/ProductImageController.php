<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Concerns\StoreImages;
use QuadStudio\Service\Site\Http\Requests\ImageRequest;
use QuadStudio\Service\Site\Models\Product;


class ProductImageController extends Controller
{

    use StoreImages;

    public function index(ImageRequest $request, Product $product)
    {
        $images = $this->getImages($request, $product);

        return view('site::admin.product.image.index', compact('product', 'images'));
    }

    /**
     * @param \QuadStudio\Service\Site\Http\Requests\ImageRequest $request
     * @param \QuadStudio\Service\Site\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ImageRequest $request, Product $product)
    {
        return $this->storeImages($request, $product);
    }

}