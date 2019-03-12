<?php

namespace QuadStudio\Service\Site\Filters\Order;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class DistributorFilter extends Filter
{


    function apply($builder, RepositoryInterface $repository)
    {

        return $builder->whereHas('address', function ($query) {
            $query
                ->where('type_id', 6)
                ->where('addressable_id', Auth::user()->getAuthIdentifier())
                ->where('addressable_type', DB::raw('"users"'));
        });


    }

}