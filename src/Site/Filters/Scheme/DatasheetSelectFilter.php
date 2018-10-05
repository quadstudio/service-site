<?php

namespace QuadStudio\Service\Site\Filters\Scheme;

use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\Datasheet;

class DatasheetSelectFilter extends WhereFilter
{

    use BootstrapSelect;

    protected $render = true;

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options():array
    {
        $options = Datasheet::whereHas('schemes')
            ->with('file')
            ->orderBy('name')
            ->get()
            ->pluck('file.name', 'id');
        $options->prepend(trans('site::messages.select_from_list'), '');
        return $options->toArray();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'datasheet_id';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'schemes.datasheet_id';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::scheme.datasheet_id');
    }

}