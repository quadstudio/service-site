<?php

namespace QuadStudio\Service\Site\Filters\User;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class SortByRegionFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {

//        $builder = $builder->addresses()->with(['region' => function ($query) {
//            $query->orderBy('name');
//        }]);
        $builder = $builder
            ->join("addresses", function ($join) {
                $join->on("addresses.addressable_id", '=', "users.id");
                $join->on("addresses.addressable_type", '=', DB::raw('"users"'));
            })
            ->join('regions', 'regions.id', '=', 'addresses.region_id')
            ->orderBy("regions.name")
            ->orderBy("addresses.locality");

        return $builder;
    }

}