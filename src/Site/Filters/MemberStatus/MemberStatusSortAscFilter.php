<?php

namespace QuadStudio\Service\Site\Filters\MemberStatus;

use QuadStudio\Repo\Filters\OrderByFilter;

class MemberStatusSortAscFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'member_statuses.sort_order' => 'ASC'
        ];
    }

}