<?php

namespace QuadStudio\Service\Site\Filters\Repair;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapDate;
use QuadStudio\Repo\Filters\DateFilter;

class DateActToFilter extends DateFilter
{

    use BootstrapDate;

    protected $render = true;
    protected $search = 'date_act_to';

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack() && $this->filled($this->search)) {
            $builder->whereHas('act', function ($query) {
                $query->where($this->column(), $this->operator(), $this->get($this->search).' 23:59:59');
            });
        }
        //dump($builder->toSql());
        //dd($builder->getBindings());
        return $builder;
    }

    public function label()
    {
        return trans('site::repair.placeholder.date_act_to');
    }

    /**
     * @return string
     */
    public function column()
    {
        return 'acts.created_at';
    }

    protected function operator()
    {
        return '<=';
    }


}