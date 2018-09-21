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
            'file_types.sort_order' => 'ASC'
        ];
    }

}