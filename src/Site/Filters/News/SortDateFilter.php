<?php

namespace QuadStudio\Service\Site\Filters\News;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortDateFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'news.date' => 'DESC'
        ];
    }

}