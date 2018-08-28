<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\FileGroup;

class FileGroupRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return FileGroup::class;
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