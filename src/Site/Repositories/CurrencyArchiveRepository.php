<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\CurrencyArchive\CurrencySelectFilter;
use QuadStudio\Service\Site\Filters\CurrencyArchive\DateFilter;
use QuadStudio\Service\Site\Filters\CurrencyArchive\SortFilter;
use QuadStudio\Service\Site\Models\CurrencyArchive;

class CurrencyArchiveRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return CurrencyArchive::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            SortFilter::class,
            CurrencySelectFilter::class,
            DateFilter::class,
        ];
    }
}