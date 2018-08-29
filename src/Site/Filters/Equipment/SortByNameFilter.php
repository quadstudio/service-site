<?php

namespace QuadStudio\Service\Site\Filters\Equipment;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortByNameFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            env('DB_PREFIX', '') . 'equipments.name' => 'ASC'
        ];
    }

}