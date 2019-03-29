<?php

namespace QuadStudio\Service\Site\Repositories;


use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Authorization\AuthorizationStatusFilter;
use QuadStudio\Service\Site\Filters\Mounting\AuthorizationDateFromFilter;
use QuadStudio\Service\Site\Filters\Mounting\AuthorizationDateToFilter;
use QuadStudio\Service\Site\Models\Authorization;

class AuthorizationRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Authorization::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            AuthorizationStatusFilter::class,
            AuthorizationDateFromFilter::class,
            AuthorizationDateToFilter::class,
        ];
    }
}