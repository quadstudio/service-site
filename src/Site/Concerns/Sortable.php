<?php

namespace QuadStudio\Service\Site\Concerns;

use Illuminate\Http\Request;

trait Sortable
{

    public static function sort(Request $request)
    {

        foreach (array_flip($request->input('sort')) as $id => $sort_order) {
            self::query()->updateOrCreate(compact('id'), compact('sort_order'));
        }
    }
}