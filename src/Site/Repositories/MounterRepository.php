<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Mounter\MounterSortFilter;
use QuadStudio\Service\Site\Models\Mounter;

class MounterRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Mounter::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            MounterSortFilter::class,
//            MountingDateCreatedFromFilter::class,
//            MountingDateCreatedToFilter::class,
        ];
    }
}