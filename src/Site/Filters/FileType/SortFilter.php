<?php

namespace QuadStudio\Service\Site\Filters\FileType;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            env('DB_PREFIX', '') . 'file_types.sort_order' => 'ASC'
        ];
    }

}