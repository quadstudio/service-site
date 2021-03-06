<?php

namespace QuadStudio\Service\Site\Filters\Difficulty;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'difficulties.sort_order' => 'ASC'
        ];
    }

}