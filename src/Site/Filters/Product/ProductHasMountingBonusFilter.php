<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;

class ProductHasMountingBonusFilter extends WhereFilter
{

    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->has($this->name()) && $this->filled($this->name())) {
            if ($this->get($this->name()) == 0) {
                $builder = $builder->doesntHave('mounting_bonus');
            } else {
                $builder = $builder->has('mounting_bonus');
            }

        }

        return $builder;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'has_mounting_bonus';
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return [
            ''  => trans('site::messages.select_no_matter'),
            '1' => trans('site::messages.yes'),
            '0' => trans('site::messages.no'),
        ];
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'mounting_bonus';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::mounting_bonus.help.has');
    }
}