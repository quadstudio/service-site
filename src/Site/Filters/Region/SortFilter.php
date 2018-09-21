<?php

namespace QuadStudio\Service\Site\Filters\Region;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'regions.name' => 'ASC'
        ];
    }
}