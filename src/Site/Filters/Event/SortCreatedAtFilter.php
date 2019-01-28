<?php

namespace QuadStudio\Service\Site\Filters\Event;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortCreatedAtFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'events.created_at' => 'DESC'
        ];
    }

}