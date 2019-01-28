<?php

namespace QuadStudio\Service\Site\Filters\News;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortCreatedAtFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'news.created_at' => 'DESC'
        ];
    }

}