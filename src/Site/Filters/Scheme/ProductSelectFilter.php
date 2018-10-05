<?php

namespace QuadStudio\Service\Site\Filters\Scheme;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\Product;

class ProductSelectFilter extends WhereFilter
{

    use BootstrapSelect;

    protected $render = true;

    public function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack() && !is_null($this->get($this->name()))) {
            $builder = $builder->whereHas('datasheet.products', function ($query) {
                $query->where(DB::raw($this->column()), $this->operator(), $this->get($this->name()));
            });
        }

        return $builder;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        $options = Product::has('datasheets.schemes')
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id');
        $options->prepend(trans('site::messages.select_from_list'), '');

        return $options->toArray();
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'product_id';
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
        return trans('site::datasheet.help.products');
    }

}