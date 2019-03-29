<?php

namespace QuadStudio\Service\Site\Repositories;


use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\AuthorizationBrand;

class AuthorizationBrandRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return AuthorizationBrand::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [];
    }
}