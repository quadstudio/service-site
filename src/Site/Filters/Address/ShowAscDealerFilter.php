<?php

namespace QuadStudio\Service\Site\Filters\Address;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class ShowAscDealerFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {

        if ($this->canTrack() && $this->filled('show')) {
            $builder = $builder->whereHas('users.roles', function ($query) {
                $query->where(function ($query) {
                    $checkboxes = $this->get('show');
                    if (in_array('asc', $checkboxes)) {
                        $query->orWhere('name', "asc");
                    }
                    if (in_array('dealer', $checkboxes)) {
                        $query->orWhere('name', "dealer");
                    }
                });
            });


        } else {
            $builder = $builder->whereRaw('false');
        }
//        dump($builder->getBindings());
//        dd($builder->toSql());
        return $builder;
    }
}