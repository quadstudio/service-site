<?php

namespace QuadStudio\Service\Site\Repositories;


use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Repair\ClientSearchFilter;
use QuadStudio\Service\Site\Filters\Repair\PartSearchFilter;
use QuadStudio\Service\Site\Filters\Repair\SearchFilter;
use QuadStudio\Service\Site\Filters\Repair\SortFilter;
use QuadStudio\Service\Site\Filters\Repair\StatusFilter;
use QuadStudio\Service\Site\Models\Repair;

class RepairRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Repair::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            SortFilter::class,
            StatusFilter::class,
            SearchFilter::class,
            ClientSearchFilter::class,
            PartSearchFilter::class,
        ];
    }
}