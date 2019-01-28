<?php

namespace QuadStudio\Service\Site\Repositories;


use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\Service;

class ServiceRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Service::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [];
    }
}