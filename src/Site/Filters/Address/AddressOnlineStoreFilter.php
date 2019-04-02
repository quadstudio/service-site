<?php

namespace QuadStudio\Service\Site\Filters\Address;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class AddressOnlineStoreFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder
            ->where('is_eshop', 1)
            ->where('active', 1)
            ->whereNotNull('web')
            ->whereHas('users', function ($query) {
                $query
                    ->where('display', 1)
                    ->where('active', 1)
                    ->whereHas('roles', function ($query) {
                        $query->where('name', 'eshop');
                    });
            });

        return $builder;
    }

}