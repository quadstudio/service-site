<?php

namespace QuadStudio\Service\Site\Filters\User;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class UserIsEShopFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->whereHas('users', function ($query) {
            $query->whereHas('roles', function ($query) {
                $query->where('name', 'eshop');
            });
        });

        return $builder;
    }
}