<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\Item;

class NewsRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Item::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [

        ];
    }
}