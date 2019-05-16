<?php

namespace QuadStudio\Service\Site\Filters\Datasheet;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\FileType;

class DatasheetTypeSelectFilter extends WhereFilter
{
    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack() && !is_null($type_id = $this->get($this->name()))) {
            $builder = $builder->whereHas('file', function ($file) use ($type_id) {
                $file->where($this->column(), $type_id);
            });
        }

        return $builder;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'type';
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
        return FileType::query()
            ->where('group_id', 2)
            ->whereHas('files', function ($file) {
                $file->has('datasheets');
            })
            ->orderBy('sort_order')
            ->pluck('name', 'id')
            ->prepend(trans('site::datasheet.type_defaults'), '')
            ->toArray();
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