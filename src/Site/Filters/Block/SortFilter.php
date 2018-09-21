<?php

namespace QuadStudio\Service\Site\Filters\Block;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'blocks.sort_order' => 'ASC'
        ];
    }

}