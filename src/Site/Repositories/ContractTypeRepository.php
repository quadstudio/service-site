<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\ContractType;

class ContractTypeRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return ContractType::class;
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