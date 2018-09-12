<?php

namespace QuadStudio\Service\Site\Filters\User;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortByCreatedAtFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            env('DB_PREFIX', '') . 'users.created_at' => 'DESC'
        ];
    }

}