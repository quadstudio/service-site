<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;
use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Models\Price;

class ProductHasPriceFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->whereHas('prices', function ($query) {

            $type_id = Auth::guest() ? config('shop.default_price_type') :  Auth::user()->profile->price_type_id;

            $query->where((new Price())->getTable().'.type_id', '=', $type_id);
        });

        return $builder;
    }

}