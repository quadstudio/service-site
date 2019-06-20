<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Models\Contract;

class ContractRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Contract::class;
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