<?php

namespace QuadStudio\Service\Site\Repositories;


use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\AuthorizationRole;

class AuthorizationRoleRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return AuthorizationRole::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [];
    }
}