<?php

namespace QuadStudio\Service\Site\Filters\Engineer;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'engineers.name' => 'ASC'
        ];
    }

}