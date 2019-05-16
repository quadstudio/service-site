<?php

namespace QuadStudio\Service\Site\Concerns;

use Illuminate\Http\Request;

trait Sortable
{

    public static function sort(Request $request)
    {
        $sort = array_flip($request->input('sort'));

        foreach ($sort as $sort_id => $sort_order) {
            self::query()->updateOrCreate(['id' => $sort_id], ['sort_order' => $sort_order]);
        }
    }
}