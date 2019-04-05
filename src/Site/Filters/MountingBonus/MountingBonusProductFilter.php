<?php

namespace QuadStudio\Service\Site\Filters\MountingBonus;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\Product;

class MountingBonusProductFilter extends WhereFilter
{

    use BootstrapSelect;

    protected $render = true;

    /**
     * @param $builder
     * @param RepositoryInterface $repository
     * @return mixed
     */
    function apply($builder, RepositoryInterface $repository)
    {

        if ($this->canTrack() && $this->filled($this->name())) {
            $builder = $builder->where('product_id', $this->get($this->name()));
        }

        return $builder;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'product_id';
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        $options = Product::has('mounting_bonus')
            ->orderBy('name')
            ->pluck('name', 'id');
        $options->prepend(trans('site::messages.select_from_list'), '');

        return $options->toArray();
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'mounting_bonuses.product_id';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::mounting_bonus.product_id');
    }

}