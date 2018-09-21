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
            'organizations.name' => 'ASC'
        ];
    }
}