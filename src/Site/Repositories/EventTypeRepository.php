<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\EventType\SortFilter;
use QuadStudio\Service\Site\Models\EventType;

class EventTypeRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return EventType::class;
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