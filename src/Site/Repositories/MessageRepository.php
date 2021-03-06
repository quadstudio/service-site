<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Message\SearchFilter;
use QuadStudio\Service\Site\Filters\Message\SortFilter;
use QuadStudio\Service\Site\Models\Message;

class MessageRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Message::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            SortFilter::class,
            SearchFilter::class
        ];
    }
}