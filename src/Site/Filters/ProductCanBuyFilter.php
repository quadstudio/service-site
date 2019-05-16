<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class ProductCanBuyFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {

        $builder = $builder
            ->where(config('site.check_field'), 1)
            ->where('enabled', 1)
            ->where('service', 0)
            ->whereNull('equipment_id');

        return $builder;
    }

}