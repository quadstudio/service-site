<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\EquipmentCatalogSelectFilter;
use QuadStudio\Service\Site\Filters\EquipmentSearchFilter;
use QuadStudio\Service\Site\Models\Equipment;

class EquipmentRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Equipment::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            EquipmentSearchFilter::class,
            EquipmentCatalogSelectFilter::class,
        ];
    }
}