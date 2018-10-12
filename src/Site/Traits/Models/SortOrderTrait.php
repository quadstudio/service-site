<?php

namespace QuadStudio\Service\Site\Traits\Models;

use Illuminate\Http\Request;

trait SortOrderTrait
{

    public static function sort(Request $request)
    {
        $sort = array_flip($request->input('sort'));

        foreach ($sort as $sort_id => $sort_order) {
            self::updateOrCreate(['id' => $sort_id], ['sort_order' => $sort_order]);
        }
    }
}