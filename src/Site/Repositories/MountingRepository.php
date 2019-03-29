<?php

namespace QuadStudio\Service\Site\Repositories;


use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Mounting\MountingActIncludeFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingClientSearchFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingEquipmentFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingSortFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingDateFromFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingDateToFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingStatusFilter;
use QuadStudio\Service\Site\Models\Mounting;

class MountingRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Mounting::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            MountingSortFilter::class,
            MountingClientSearchFilter::class,
            MountingStatusFilter::class,
            MountingEquipmentFilter::class,
            MountingActIncludeFilter::class,
            MountingDateFromFilter::class,
            MountingDateToFilter::class
        ];
    }
}