<?php

namespace QuadStudio\Service\Site\Filters\Trade;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'trades.name' => 'ASC'
        ];
    }

}