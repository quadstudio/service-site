<?php

namespace QuadStudio\Service\Site\Repositories;


use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\MountingBonus\MountingBonusProductFilter;
use QuadStudio\Service\Site\Filters\MountingBonus\MountingBonusEquipmentFilter;
use QuadStudio\Service\Site\Models\MountingBonus;

class MountingBonusRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return MountingBonus::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [
            MountingBonusEquipmentFilter::class,
            MountingBonusProductFilter::class
        ];
    }
}