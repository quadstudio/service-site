<?php

namespace QuadStudio\Service\Site\Repositories;


use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Block\SortFilter;
use QuadStudio\Service\Site\Models\Block;

class BlockRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Block::class;
    }

    /**
     * @return array
     */
    public function track():array
    {
        return [
            SortFilter::class
        ];
    }
}