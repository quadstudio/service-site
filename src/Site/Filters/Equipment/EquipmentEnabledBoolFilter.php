<?php

namespace QuadStudio\Service\Site\Filters\Equipment;

use QuadStudio\Repo\Filters\BooleanFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class EquipmentEnabledBoolFilter extends BooleanFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'enabled';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'equipments.enabled';

    }

    public function defaults(): array
    {
        return [];
    }

    public function label()
    {
        return trans('site::equipment.enabled');
    }
}