<?php

namespace QuadStudio\Service\Site\Filters\Announcement;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortDateFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'announcements.date' => 'DESC'
        ];
    }

}