<?php

namespace QuadStudio\Service\Site\Repositories;


use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\Warehouse;

class WarehouseRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Warehouse::class;
    }

    /**
     * @return array
     */
    public function track():array
    {
        return [];
    }
}