<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Http\Requests\Admin\ProductDetailRequest;
use QuadStudio\Service\Site\Models\Product;

class ProductDetailController extends Controller
{

    /**
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $details = $product->details()->orderBy('name')->get();

        return view('site::admin.product.detail.index', compact('product', 'details'));
    }

    /**
     * @param ProductDetailRequest $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(ProductDetailRequest $request, Product $product)
    {

        $sku = collect(preg_split(
            "/[{$request->input('separator_row')}]+/",
            $request->input('details'),
            null,
            PREG_SPLIT_NO_EMPTY
        ));
        if (!empty($sku)) {
            $sku = $sku->filter(function ($value, $key) {
                return strpos($value, " ") === false && mb_strlen($value, 'UTF-8') > 0;
            });
            $details = Product::query()->whereIn('sku', $sku->toArray())->get();
            /** @var Product $detail */
            foreach ($details as $detail) {
                if (!$product->details->contains($detail->id)) {
                    $product->attachDetail($detail);
                }
            }
        }

        return redirect()->route('admin.products.details.index', $product)->with('success', trans('site::detail.added'));
    }

    public function destroy(ProductDetailRequest $request, Product $product)
    {

        $product->detachDetails($request->input('delete'));

        return redirect()->route('admin.products.details.index', $product)->with('success', trans('site::detail.deleted'));
    }
}