<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Filters\OrderByFilter;

class CountrySortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            env('DB_PREFIX', '') . 'countries.sort_order' => 'ASC'
        ];
    }

}