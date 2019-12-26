<?php

namespace QuadStudio\Service\Site\Filters\Repair;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapTempusDominusDate;
use QuadStudio\Repo\Filters\DateFilter;

class RepairDateActToFilter extends DateFilter
{

    use BootstrapTempusDominusDate;

    protected $render = true;
    protected $search = 'date_act_to';

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack() && $this->filled($this->search)) {
            $builder->whereHas('act', function ($query) {
            //    $query->where($this->column(), $this->operator(), $this->get($this->search) . ' 23:59:59');
				$query->where($this->column(), $this->operator(),  date('Y-m-d', strtotime($this->get($this->search))));
            });
			
        }
        //dump($builder->toSql());
        //dd($builder->getBindings());
        return $builder;
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

    public function label()
    {
        return trans('site::repair.help.date_act');
    }

    protected function placeholder()
    {
        return trans('site::repair.placeholder.date_to');
    }

    protected function attributes()
    {
        return parent::attributes()->merge(['style' => 'width:100px;']);
    }

}