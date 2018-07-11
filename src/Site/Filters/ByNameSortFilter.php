<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Filters\OrderByFilter;

class ByNameSortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            $this->table . '.name' => 'ASC'
        ];
    }
}