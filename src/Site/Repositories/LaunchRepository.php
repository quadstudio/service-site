<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Launch\SearchFilter;
use QuadStudio\Service\Site\Filters\Launch\SortFilter;
use QuadStudio\Service\Site\Models\Launch;

class LaunchRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Launch::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            SortFilter::class,
            SearchFilter::class
        ];
    }
}