<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;
use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Models\Price;

class ProductNotZeroPriceFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->whereHas('prices', function ($query) {
            $type_id = Auth::guest() ? config('site.defaults.guest.price_type_id') :  Auth::user()->price_type_id;
            $table = (new Price())->getTable();
            $query->where($table.'.type_id', '=', $type_id)->where($table.'.price', '<>', 0.00);
        });
        return $builder;
    }
}