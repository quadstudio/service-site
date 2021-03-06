<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Engineer\SearchFilter;
use QuadStudio\Service\Site\Filters\Engineer\SortFilter;
use QuadStudio\Service\Site\Models\Engineer;

class EngineerRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Engineer::class;
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