<?php

namespace QuadStudio\Service\Site\Filters\Event;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortDateFromFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'events.date_from' => 'ASC'
        ];
    }

}