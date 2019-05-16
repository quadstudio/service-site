<?php

namespace QuadStudio\Service\Site\Filters\Address;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class AddressWhereToBuyFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder
            ->where('is_shop', 1)
            ->where(config('site.check_field'), 1)
            ->whereHas('users', function ($query) {
                $query
                    ->where('display', 1)
                    ->where('active', 1);
            });

        return $builder;
    }

}