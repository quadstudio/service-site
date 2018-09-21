<?php

namespace QuadStudio\Service\Site\Filters\CurrencyArchive;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapSelect;
use QuadStudio\Repo\Filters\WhereFilter;
use QuadStudio\Service\Site\Models\AddressType;
use QuadStudio\Service\Site\Models\Currency;
use QuadStudio\Service\Site\Models\Region;

class CurrencySelectFilter extends WhereFilter
{
    use BootstrapSelect;

    protected $render = true;

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack() && !is_null($value = $this->get($this->name()))) {
            $builder = $builder->where(DB::raw($this->column()), $this->operator(), $value);
        }

        return $builder;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'currency_id';
    }

    /**
     * @return string
     */
    public function column(): string
    {

        return 'currency_id';

    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return array
     */
    public function options(): array
    {
        return Currency::has('archives')
            ->pluck('title', 'id')
            ->prepend(trans('site::messages.select_from_list'), '')
            ->toArray();
    }

    public function defaults(): array
    {
        return [''];
    }

    public function label()
    {
        return trans('site::archive.currency_id');
    }
}