<?php

namespace QuadStudio\Service\Site\Filters\Launch;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'launches.name' => 'ASC'
        ];
    }

}