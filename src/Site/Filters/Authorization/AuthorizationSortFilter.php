<?php

namespace QuadStudio\Service\Site\Filters\Authorization;

use QuadStudio\Repo\Filters\OrderByFilter;

class AuthorizationSortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'authorizations.created_at' => 'DESC'
        ];
    }
}