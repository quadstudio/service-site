<?php

namespace QuadStudio\Service\Site\Repositories;


use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Region\SortFilter;
use QuadStudio\Service\Site\Models\Region;

class RegionRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Region::class;
    }

    /**
     * @return array
     */
    public function track():array
    {
        return [
            SortFilter::class
        ];
    }
}