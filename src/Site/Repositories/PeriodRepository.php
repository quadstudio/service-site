<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\Period;

class PeriodRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Period::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [

        ];
    }
}