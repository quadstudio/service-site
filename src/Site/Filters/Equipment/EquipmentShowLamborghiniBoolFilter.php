<?php

namespace QuadStudio\Service\Site\Filters\Equipment;

use QuadStudio\Repo\Filters\BooleanFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class EquipmentShowLamborghiniBoolFilter extends BooleanFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'show_lamborghini';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'equipments.show_lamborghini';

    }

    public function defaults(): array
    {
        return [];
    }

    public function label()
    {
        return trans('site::messages.show_lamborghini');
    }
}