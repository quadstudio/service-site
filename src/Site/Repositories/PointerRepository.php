<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\Pointer;

class PointerRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Pointer::class;
    }

    /**
     * @return array
     */
    public function track():array
    {
        return [];
    }
}