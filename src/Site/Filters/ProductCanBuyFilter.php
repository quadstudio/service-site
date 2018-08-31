<?php

namespace QuadStudio\Service\Site\Filters;

use Illuminate\Support\Facades\Auth;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;
use QuadStudio\Service\Site\Models\Price;

class ProductCanBuyFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {

        $builder = $builder
            ->where('active', 1)
            ->where('enabled', 1)
            ->where('service', 0)
            ->whereNull('equipment_id')
//            ->whereHas('prices', function ($query) {
//                $type_id = Auth::guest() ? config('site.defaults.guest.price_type_id') : Auth::user()->price_type_id;
//
//                $table = (new Price())->getTable();
//                $query
//                    ->where($table . '.type_id', '=', $type_id)
//                    ->where($table . '.price', '<>', 0.00);
//            })
        ;
        //dump($builder->toSql());
        //dd($builder->getBindings());
        return $builder;
    }

}