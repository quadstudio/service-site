<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Bank\SearchFilter;
use QuadStudio\Service\Site\Models\Bank;

class BankRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Bank::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            SearchFilter::class
        ];
    }
}