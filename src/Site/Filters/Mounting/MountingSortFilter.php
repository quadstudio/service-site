<?php

namespace QuadStudio\Service\Site\Filters\Mounting;

use QuadStudio\Repo\Filters\OrderByFilter;

class MountingSortFilter extends OrderByFilter
{

    /**
     * @return array
     */
    public function defaults(): array
    {
        return [
            'mountings.created_at' => 'DESC'
        ];
    }
}