<?php

namespace QuadStudio\Service\Site\Filters\Act;

use QuadStudio\Repo\Filters\BooleanFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class ActBoolPaidFilter extends BooleanFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'paid';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'acts.paid';

    }

    public function defaults(): array
    {
        return [];
    }

    public function label()
    {
        return auth()->user()->admin ? trans('site::act.paid') : trans('site::act.user.paid');
    }
}