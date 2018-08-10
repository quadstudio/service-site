<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\RepairStatus\SortFilter;
use QuadStudio\Service\Site\Models\RepairStatus;

class RepairStatusRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return RepairStatus::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            SortFilter::class
        ];
    }
}