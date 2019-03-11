<?php

namespace QuadStudio\Service\Site\Filters\District;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'districts.sort_order' => 'ASC'
        ];
    }
}