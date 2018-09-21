<?php

namespace QuadStudio\Service\Site\Filters\Message;

use QuadStudio\Repo\Filters\OrderByFilter;

class SortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'messages.created_at' => 'DESC'
        ];
    }
}