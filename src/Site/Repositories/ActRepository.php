<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Act\ActContragentFilter;
use QuadStudio\Service\Site\Filters\Act\ActDateCreatedFromFilter;
use QuadStudio\Service\Site\Filters\Act\ActDateCreatedToFilter;
use QuadStudio\Service\Site\Filters\Act\ActSortFilter;
use QuadStudio\Service\Site\Filters\Act\ActTypeFilter;
use QuadStudio\Service\Site\Filters\Act\ActBoolPaidFilter;
use QuadStudio\Service\Site\Filters\Act\ActBoolReceivedFilter;
use QuadStudio\Service\Site\Models\Act;

class ActRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Act::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            ActSortFilter::class,
            ActContragentFilter::class,
            ActBoolReceivedFilter::class,
            ActBoolPaidFilter::class,
            ActDateCreatedFromFilter::class,
            ActDateCreatedToFilter::class,
            ActTypeFilter::class,
        ];
    }
}