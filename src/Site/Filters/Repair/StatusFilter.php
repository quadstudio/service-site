<?php

namespace QuadStudio\Service\Site\Filters\Repair;

use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\RepairStatus;

class StatusFilter extends WhereFilter
{
    use BootstrapSelect;

    protected $render = true;

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return ['' => trans('site::repair.status_defaults')] + RepairStatus::orderBy('id')->pluck('name', 'id')->toArray();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'status_id';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'status_id';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::repair.status_id');
    }
}