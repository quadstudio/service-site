<?php

namespace QuadStudio\Service\Site\Filters\RepairStatus;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'repair_statuses.sort_order' => 'ASC'
        ];
    }
}