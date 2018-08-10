<?php

namespace QuadStudio\Service\Site\Filters\RepairStatus;

use Illuminate\Support\Facades\Auth;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;
use QuadStudio\Service\Site\Models\Repair;

class NextFilter extends Filter
{
    /**
     * @var Repair|null
     */
    private $repair;

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->whereIn('id', config('site.repair_status_transition.' .(Auth::user()->admin == 1 ? 'admin' : 'user').'.'. $this->repair->getAttribute('status_id'), []));

        return $builder;
    }


    /**
     * @param Repair $repair
     * @return $this
     */
    public function setRepair(Repair $repair = null)
    {
        $this->repair = $repair;

        return $this;
    }
}