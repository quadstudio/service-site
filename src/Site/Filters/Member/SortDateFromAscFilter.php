<?php

namespace QuadStudio\Service\Site\Filters\Member;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortDateFromAscFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'members.date_from' => 'ASC'
        ];
    }

}