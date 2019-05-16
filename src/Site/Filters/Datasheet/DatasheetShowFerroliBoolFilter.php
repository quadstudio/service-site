<?php

namespace QuadStudio\Service\Site\Filters\Datasheet;

use QuadStudio\Repo\Filters\BooleanFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class DatasheetShowFerroliBoolFilter extends BooleanFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * @return string
     */
    public function name(): string
    {
        return 'show_ferroli';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'datasheets.show_ferroli';

    }

    public function defaults(): array
    {
        return [];
    }

    public function label()
    {
        return trans('site::messages.show_ferroli');
    }
}