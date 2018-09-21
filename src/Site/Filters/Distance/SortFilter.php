<?php

namespace QuadStudio\Service\Site\Filters\Distance;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'distances.sort_order' => 'ASC'
        ];
    }

}