<?php

namespace QuadStudio\Service\Site\Filters\Member;

use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\EventType;

class MemberTypeSelectFilter extends WhereFilter
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
        $options = EventType::query()->orderBy('sort_order');
        if (auth()->user()->admin == 0) {
            $options->where(config('site.check_field'), 1);
        }
        return $options
            ->pluck('name', 'id')
            ->prepend(trans('site::messages.select_from_list'), '')
            ->toArray();

    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'type_id';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'members.type_id';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::member.type_id');
    }

}