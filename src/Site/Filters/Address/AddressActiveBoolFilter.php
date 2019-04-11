<?php

namespace QuadStudio\Service\Site\Filters\Address;

use QuadStudio\Repo\Filters\BooleanFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class AddressActiveBoolFilter extends BooleanFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'active';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'addresses.active';

    }

    public function defaults(): array
    {
        return [];
    }

    public function label()
    {
        return trans('site::address.active');
    }
}