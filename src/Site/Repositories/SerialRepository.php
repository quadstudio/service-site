<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\Serial\ProductSearchFilter;
use QuadStudio\Service\Site\Filters\Serial\SearchFilter;
use QuadStudio\Service\Site\Models\Serial;

class SerialRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Serial::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            SearchFilter::class,
            ProductSearchFilter::class
        ];
    }
}