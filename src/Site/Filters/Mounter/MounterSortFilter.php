<?php

namespace QuadStudio\Service\Site\Filters\Mounter;

use QuadStudio\Repo\Filters\OrderByFilter;

class MounterSortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'mounters.created_at' => 'DESC'
        ];
    }
}