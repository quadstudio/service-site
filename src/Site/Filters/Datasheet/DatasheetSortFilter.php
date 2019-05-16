<?php

namespace QuadStudio\Service\Site\Filters\Datasheet;

use QuadStudio\Repo\Filters\OrderByFilter;

class DatasheetSortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'datasheets.created_at' => 'DESC'
        ];
    }

}