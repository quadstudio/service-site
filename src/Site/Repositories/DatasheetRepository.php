<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Datasheet\DatasheetSearchFilter;
use QuadStudio\Service\Site\Filters\Datasheet\DatasheetSortFilter;
use QuadStudio\Service\Site\Filters\Datasheet\DatasheetTypeSelectFilter;
use QuadStudio\Service\Site\Models\Datasheet;

class DatasheetRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Datasheet::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            DatasheetSortFilter::class,
            DatasheetSearchFilter::class,
            DatasheetTypeSelectFilter::class,
        ];
    }
}