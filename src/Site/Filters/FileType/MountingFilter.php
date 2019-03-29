<?php

namespace QuadStudio\Service\Site\Filters\FileType;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class MountingFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->whereGroupId(1);
        return $builder;
    }

}