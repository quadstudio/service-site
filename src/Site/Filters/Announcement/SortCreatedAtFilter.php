<?php

namespace QuadStudio\Service\Site\Filters\Announcement;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortCreatedAtFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'announcements.created_at' => 'DESC'
        ];
    }

}