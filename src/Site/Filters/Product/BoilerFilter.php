<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\Product;

class BoilerFilter extends WhereFilter
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
        $builder->when($this->canTrack() && $this->filled($this->name()), function($query){
            return $query->whereHas('relations', function($query){
                $boiler_id = $this->get($this->name());
                return $query->where('details.product_id', $boiler_id);
            });
        });

        //dump($builder->getBindings());
        //dd($builder->toSql());
        return $builder;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'boiler_id';
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        $options = Product::query()->whereHas('details', function ($query) {
            $query->where('enabled', 1)->where(config('site.check_field'), 1)->whereNull('equipment_id');
        })
            ->where('enabled', 1)
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

        return 'products.id';

    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::product.header.boiler');
    }

}