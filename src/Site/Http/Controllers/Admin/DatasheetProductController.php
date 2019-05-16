<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Http\Requests\Admin\DatasheetProductRequest;
use QuadStudio\Service\Site\Models\Datasheet;
use QuadStudio\Service\Site\Models\Product;

class DatasheetProductController extends Controller
{

    /**
     * @param Datasheet $datasheet
     * @return \Illuminate\Http\Response
     */
    public function index(Datasheet $datasheet)
    {
        $products = $datasheet->products()->orderBy('name')->get();

        return view('site::admin.datasheet.product.index', compact('datasheet', 'products'));
    }

    /**
     * @param DatasheetProductRequest $request
     * @param Datasheet $datasheet
     * @return \Illuminate\Http\Response
     */
    public function store(DatasheetProductRequest $request, Datasheet $datasheet)
    {

        $sku = collect(preg_split(
            "/[{$request->input('separator_row')}]+/",
            $request->input('products'),
            null,
            PREG_SPLIT_NO_EMPTY
        ));
        if (!empty($sku)) {
            $sku = $sku->filter(function ($value, $key) {
                return strpos($value, " ") === false && mb_strlen($value, 'UTF-8') > 0;
            });
            $products = Product::query()->whereIn('sku', $sku->toArray())->get();
            /** @var Datasheet $product */
            foreach ($products as $product) {
                if (!$datasheet->products->contains($product->id)) {
                    $datasheet->attachProduct($product);
                }
            }
        }

        return redirect()->route('admin.datasheets.products.index', $datasheet)->with('success', trans('site::product.added'));
    }

    public function destroy(DatasheetProductRequest $request, Datasheet $datasheet)
    {

        $datasheet->detachProducts($request->input('delete'));

        return redirect()->route('admin.datasheets.products.index', $datasheet)->with('success', trans('site::product.deleted'));
    }
}