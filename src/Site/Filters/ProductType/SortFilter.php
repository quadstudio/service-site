<?php

namespace QuadStudio\Service\Site\Filters\ProductType;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'product_types.name' => 'ASC'
        ];
    }
}