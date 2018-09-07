<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'products.name' => 'ASC'
        ];
    }

}