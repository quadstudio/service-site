<?php

namespace QuadStudio\Service\Site\Filters\Page;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'pages.h1' => 'ASC'
        ];
    }

}