<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Http\Requests\Admin\ProductRelationRequest;
use QuadStudio\Service\Site\Models\Product;

class ProductRelationController extends Controller
{

    /**
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $relations = $product->relations()->orderBy('name')->get();

        return view('site::admin.product.relation.index', compact('product', 'relations'));
    }

    /**
     * @param ProductRelationRequest $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRelationRequest $request, Product $product)
    {

        $sku = collect(preg_split(
            "/[{$request->input('separator_row')}]+/",
            $request->input('relations'),
            null,
            PREG_SPLIT_NO_EMPTY
        ));
        if (!empty($sku)) {
            $sku = $sku->filter(function ($value, $key) {
                return strpos($value, " ") === false && mb_strlen($value, 'UTF-8') > 0;
            });
            $relations = Product::query()->whereIn('sku', $sku->toArray())->get();
            /** @var Product $relation */
            foreach ($relations as $relation) {
                if (!$product->relations->contains($relation->id)) {
                    $product->attachRelation($relation);
                }
            }
        }

        return redirect()->route('admin.products.relations.index', $product)->with('success', trans('site::relation.added'));
    }

    public function destroy(ProductRelationRequest $request, Product $product)
    {

        $product->detachRelations($request->input('delete'));

        return redirect()->route('admin.products.relations.index', $product)->with('success', trans('site::relation.deleted'));
    }
}