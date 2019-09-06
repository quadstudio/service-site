<?php

namespace QuadStudio\Service\Site\Repositories;


use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\StorehouseLog;

class StorehouseLogRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return StorehouseLog::class;
    }

    /**
     * @return array
     */
    public function track():array
    {
        return [];
    }
}