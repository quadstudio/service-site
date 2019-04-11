<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Http\Requests\Admin\ProductAnalogRequest;
use QuadStudio\Service\Site\Models\Product;

class ProductAnalogController extends Controller
{

    /**
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $analogs = $product->analogs()->orderBy('name')->get();

        return view('site::admin.product.analog.index', compact('product', 'analogs'));
    }

    /**
     * @param ProductAnalogRequest $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(ProductAnalogRequest $request, Product $product)
    {

        $sku = collect(preg_split(
            "/[{$request->input('separator_row')}]+/",
            $request->input('analogs'),
            null,
            PREG_SPLIT_NO_EMPTY
        ));
        if (!empty($sku)) {
            $sku = $sku->filter(function ($value, $key) {
                return strpos($value, " ") === false && mb_strlen($value, 'UTF-8') > 0;
            });
            $analogs = Product::query()->whereIn('sku', $sku->toArray())->get();
            /** @var Product $analog */
            foreach ($analogs as $analog) {
                if (!$product->analogs->contains($analog->id)) {
                    $product->attachAnalog($analog);
                }
                if (
                    $request->has('mirror')
                    && $request->input('mirror') == 1
                    && !$analog->analogs->contains($product->id)
                ) {
                    $analog->attachAnalog($product);
                }
            }
        }

        return redirect()->route('admin.products.analogs.index', $product)->with('success', trans('site::analog.added'));
    }

    public function destroy(ProductAnalogRequest $request, Product $product)
    {

        $product->detachAnalogs($request->input('delete'));

        if ($request->has('mirror_delete')) {
            foreach ($request->input('delete') as $analog_id) {
                /** @var Product $analog */
                $analog = Product::query()->find($analog_id);
                $analog->detachAnalog($product);
            }
        }

        return redirect()->route('admin.products.analogs.index', $product)->with('success', trans('site::analog.deleted'));
    }
}