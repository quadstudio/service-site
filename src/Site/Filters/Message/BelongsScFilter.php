<?php

namespace QuadStudio\Service\Site\Filters\Message;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;
use Illuminate\Support\Facades\Auth;

class BelongsScFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {

        $builder = $builder->where(function ($query) use ($repository){
            $query->orWhere($repository->getTable().'.user_id', Auth::user()->getAuthIdentifier());
            $query->orWhere($repository->getTable().'.receiver_id', Auth::user()->getAuthIdentifier());
        });
        return $builder;
    }
}