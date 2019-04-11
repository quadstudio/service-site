<?php

namespace QuadStudio\Service\Site\Filters\Act;

use QuadStudio\Repo\Filters\OrderByFilter;

class ActSortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'acts.created_at' => 'DESC'
        ];
    }
}