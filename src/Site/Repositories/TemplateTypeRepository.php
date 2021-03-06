<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\TemplateType;

class TemplateTypeRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return TemplateType::class;
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