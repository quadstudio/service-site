<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Http\Request;
use QuadStudio\Service\Site\Models\Product;

trait AnalogControllerTrait
{

    public function store(Request $request, Product $product)
    {
        $json = [];
        $analog = Product::find($request->input('analog_id'));
        if (!$product->analogs->contains($analog->id)) {
            $product->attachAnalog($analog);
            $json['update']['#product-analogs-count'] = $product->analogs()->count();
            $json['prepend']['#product-analogs-list'] = view('site::admin.product.show.analog', compact('product', 'analog'))->render();
        } else {
            $json['errors']['#analog_search'] = 'Такой аналог уже есть';
        }

        if ($request->has('mirror') && $request->input('mirror') == 1) {
            $analog->attachAnalog($product);
        }

        return response()->json($json);
    }

    public function destroy(Request $request, Product $product, Product $analog)
    {
        $product->detachAnalog($analog);
        if ($request->has('mirror') && $request->input('mirror') == 1) {
            $analog->detachAnalog($product);
        }
        $json['remove'][] = '#product-analog-' . $analog->id;
        $json['update']['#product-analogs-count'] = $product->analogs()->count();

        return response()->json($json);
    }
}