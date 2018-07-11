<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
//use QuadStudio\Service\Site\Filters\PriceSearchFilter;
//use QuadStudio\Service\Site\Filters\PriceSortFilter;
use QuadStudio\Service\Site\Models\Price;

class PriceRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Price::class;
    }

    /**
     * @return array
     */
    public function track():array
    {
        return [
            //PriceSortFilter::class,
            //PriceSearchFilter::class,
        ];
    }
}