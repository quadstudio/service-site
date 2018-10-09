<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Trade\SearchFilter;
use QuadStudio\Service\Site\Filters\Trade\SortFilter;
use QuadStudio\Service\Site\Models\Trade;

class TradeRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Trade::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            SortFilter::class,
            SearchFilter::class
        ];
    }
}