<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;
use QuadStudio\Repo\Filters\BootstrapCheckbox;

class CountryEnabledFilter extends Filter
{
    use BootstrapCheckbox;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        //$builder = $builder->where('enabled', 1);

        return $builder;
    }

}