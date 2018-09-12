<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\Phone;

class PhoneRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Phone::class;
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