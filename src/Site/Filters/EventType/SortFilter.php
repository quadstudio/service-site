<?php

namespace QuadStudio\Service\Site\Filters\EventType;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'event_types.sort_order' => 'ASC'
        ];
    }

}