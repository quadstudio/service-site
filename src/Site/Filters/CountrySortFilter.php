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
            'countries.sort_order' => 'ASC'
        ];
    }

}