<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\Address;

class AddressRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Address::class;
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