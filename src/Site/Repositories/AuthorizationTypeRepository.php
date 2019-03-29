<?php

namespace QuadStudio\Service\Site\Repositories;


use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\AuthorizationType;

class AuthorizationTypeRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return AuthorizationType::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [];
    }
}