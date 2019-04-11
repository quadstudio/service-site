<?php

namespace QuadStudio\Service\Site\Filters\Act;

use QuadStudio\Repo\Filters\BooleanFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class ActBoolReceivedFilter extends BooleanFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'received';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'acts.received';

    }

    public function defaults(): array
    {
        return [];
    }

    public function label()
    {
        return auth()->user()->admin ? trans('site::act.received') : trans('site::act.user.received');
    }
}