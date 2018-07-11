<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class LostCatalogImageFilter extends Filter
{

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->whereNull(env('DB_PREFIX', '').'catalog_images.catalog_id');
        return $builder;
    }
}