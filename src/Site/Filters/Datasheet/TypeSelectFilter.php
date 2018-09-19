<?php

namespace QuadStudio\Service\Site\Filters\Datasheet;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\FileType;

class TypeSelectFilter extends WhereFilter
{
    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack() && !is_null($type_id = $this->get($this->name()))) {
            $builder = $builder->whereHas('file', function ($query) use ($type_id) {
                $query->where($this->column(), $type_id);
            });
        }

        return $builder;
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

        return 'type_id';

    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return ['' => trans('site::datasheet.type_defaults')] + FileType::where('group_id', 2)->orderBy('sort_order')->pluck('name', 'id')->toArray();
    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::datasheet.type_id');
    }
}