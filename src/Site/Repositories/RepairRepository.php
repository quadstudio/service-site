<?php

namespace QuadStudio\Service\Site\Repositories;


use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Repair\ActIncludeFilter;
use QuadStudio\Service\Site\Filters\Repair\ClientSearchFilter;
use QuadStudio\Service\Site\Filters\Repair\RepairDateActFromFilter;
use QuadStudio\Service\Site\Filters\Repair\RepairDateActToFilter;
use QuadStudio\Service\Site\Filters\Repair\RepairDateFromFilter;
use QuadStudio\Service\Site\Filters\Repair\RepairDateToFilter;
use QuadStudio\Service\Site\Filters\Repair\EquipmentFilter;
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
            SearchFilter::class,
            ClientSearchFilter::class,
            PartSearchFilter::class,
            StatusFilter::class,
            ActIncludeFilter::class,
            EquipmentFilter::class,
            RepairDateFromFilter::class,
            RepairDateToFilter::class,
            RepairDateActFromFilter::class,
            RepairDateActToFilter::class,

        ];
    }
}