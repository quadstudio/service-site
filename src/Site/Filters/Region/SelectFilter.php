<?php

namespace QuadStudio\Service\Site\Filters\Region;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class SelectFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->where('country_id', config('site.country', 643));

        /**
         * ->whereHas('countries', function ($query) {
        $query->where('countries.enabled', 1);
        })
         */
        return $builder;
    }

}