<?php

namespace QuadStudio\Service\Site\Filters\Member;

use QuadStudio\Repo\Filters\OrderByFilter;

class MemberSortCreatedAtFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'members.created_at' => 'DESC'
        ];
    }

}