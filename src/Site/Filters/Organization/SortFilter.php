<?php

namespace QuadStudio\Service\Site\Filters\Organization;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            env('DB_PREFIX', '') . 'organizations.name' => 'ASC'
        ];
    }
}