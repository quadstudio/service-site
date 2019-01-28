<?php

namespace QuadStudio\Service\Site\Filters\Event;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;
use QuadStudio\Service\Site\Models\Product;

class HasMembersFilter extends Filter
{

    /**
     * @param $builder
     * @param RepositoryInterface $repository
     * @return mixed
     */
    function apply($builder, RepositoryInterface $repository)
    {

        $builder = $builder->has('members');

        return $builder;
    }

}