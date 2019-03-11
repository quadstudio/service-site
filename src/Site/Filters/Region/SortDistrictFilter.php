<?php

namespace QuadStudio\Service\Site\Filters\Region;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class SortDistrictFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder
            ->join('districts', 'districts.id', '=', 'regions.district_id')
            ->orderBy("districts.sort_order");

        return $builder;
    }

}