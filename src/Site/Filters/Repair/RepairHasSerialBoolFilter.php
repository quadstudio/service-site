<?php

namespace QuadStudio\Service\Site\Filters\Address;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BooleanFilter;
use QuadStudio\Repo\Filters\BootstrapSelect;

class RepairHasSerialBoolFilter extends BooleanFilter
{
    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {

        if ($this->canTrack() && $this->filled($this->name())) {
            switch ($this->get($this->name())){
                case 0:
                    $builder = $builder->whereNull($this->column());
                    break;
                case 1:
                    $builder = $builder->whereNotNull($this->column());
                    break;
            }
        }

        return $builder;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'has_serial';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'repairs.serial_id';

    }

    public function defaults(): array
    {
        return [];
    }

    public function label()
    {
        return trans('site::repair.help.has_serial');
    }
}