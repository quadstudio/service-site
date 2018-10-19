<?php

namespace QuadStudio\Service\Site\Filters\Region;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class RegionsSelectedFilter extends Filter
{
    /**
     * @var array
     */
    private $regions = [];

    function apply($builder, RepositoryInterface $repository)
    {
        if (!is_null($this->regions)) {
            $builder = $builder->whereIn('id', $this->regions);
        } else {
            $builder->whereRaw('false');
        }

        return $builder;

    }

    /**
     * @param array $regions
     * @return $this
     */
    public function setRegions(array $regions = [])
    {
        $this->regions = $regions;

        return $this;
    }

}