<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Http\Request;
use QuadStudio\Service\Site\Models\Product;

trait RelationControllerTrait
{

    public function store(Request $request, Product $product)
    {
        $json = [];
        $relation = Product::find($request->input('relation_id'));
        if ($request->has('back') && $request->input('back') == 1) {
            if(!$relation->relations->contains($product->id)){
                $relation->attachRelation($product);
                $json['update']['.product-back-relations-count'] = $product->back_relations()->count();
                $back = 1;
                $json['prepend']['#product-back-relations-list'] = view('site::admin.product.show.relation', compact('product', 'relation', 'back'))->render();
            }

        } else{
            if(!$product->relations->contains($relation->id)){
                $product->attachRelation($relation);
                $json['update']['.product-relations-count'] = $product->relations()->count();
                $back = 0;
                $json['prepend']['#product-relations-list'] = view('site::admin.product.show.relation', compact('product', 'relation', 'back'))->render();
            }
        }
        return response()->json($json);
    }

    public function destroy(Request $request, Product $product, Product $relation)
    {

        if($request->has('back') && $request->input('back') == 1){
            $relation->detachRelation($product);
            $count_id = '.product-back-relations-count';
            $count = $product->back_relations()->count();
            $remove = '#product-back-relation-' . $relation->id;
        } else{
            $product->detachRelation($relation);
            $count_id = '.product-relations-count';
            $count = $product->relations()->count();
            $remove = '#product-relation-' . $relation->id;
        }
        $json['update'][$count_id] = $count;
        $json['remove'][] = $remove;
        return response()->json($json);
    }
}