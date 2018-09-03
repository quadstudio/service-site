<?php

namespace QuadStudio\Service\Site\Filters\User;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class DisplayFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {

        $builder = $builder->where('display', 1);

        return $builder;
    }
}