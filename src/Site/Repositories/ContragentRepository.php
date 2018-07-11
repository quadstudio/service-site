<?php

namespace QuadStudio\Service\Site\Repositories;


use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\ContragentSearchFilter;
use QuadStudio\Service\Site\Models\Contragent;

class ContragentRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Contragent::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            ContragentSearchFilter::class,
        ];
    }
}