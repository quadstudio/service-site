<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\PriceType;

class PriceTypeRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return PriceType::class;
    }

    /**
     * @return array
     */
    public function track():array
    {
        return [
        ];
    }
}