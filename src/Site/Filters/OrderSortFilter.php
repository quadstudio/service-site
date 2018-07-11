<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Filters\OrderByFilter;

class OrderSortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            $this->table . '.created_at' => 'DESC'
        ];
    }
}