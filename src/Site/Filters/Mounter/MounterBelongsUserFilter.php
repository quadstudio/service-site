<?php

namespace QuadStudio\Service\Site\Filters\Mounter;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class MounterBelongsUserFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {

        $builder = $builder->whereHas('userAddress', function ($address) {
            $address
                ->where('addressable_type', '=', 'users')
                ->where('addressable_id', '=', auth()->user()->getAuthIdentifier());
        });

        return $builder;
    }
}