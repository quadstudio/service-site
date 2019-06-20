<?php

namespace QuadStudio\Service\Site\Filters\Contract;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class ContractBelongsUserFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {

        $builder = $builder->whereHas('contragent', function ($address) {
            $address->where('user_id', '=', auth()->user()->getAuthIdentifier());
        });

        return $builder;
    }
}