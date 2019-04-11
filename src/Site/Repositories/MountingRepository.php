<?php

namespace QuadStudio\Service\Site\Repositories;


use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Mounting\MountingActIncludeFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingClientSearchFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingDateCreatedFromFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingDateCreatedToFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingEquipmentFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingProductFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingSortFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingDateMountingFromFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingDateMountingToFilter;
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
            MountingProductFilter::class,
            MountingDateCreatedFromFilter::class,
            MountingDateCreatedToFilter::class,
            MountingDateMountingFromFilter::class,
            MountingDateMountingToFilter::class,
            MountingActIncludeFilter::class,
        ];
    }
}