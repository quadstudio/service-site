<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\Act;

class ActRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Act::class;
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