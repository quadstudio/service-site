<?php

namespace QuadStudio\Service\Site\Filters\Address;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class RegionFilter extends Filter
{
    /**
     * @var string|null
     */
    private $region_id;

    function apply($builder, RepositoryInterface $repository)
    {
        if (!is_null($this->region_id)) {
            $builder->where('region_id', $this->region_id);
        } else {
            $builder->whereRaw('false');
        }

        return $builder;
    }

    /**
     * @param string $region_id
     * @return $this
     */
    public function setRegionId($region_id = null)
    {
        $this->region_id = $region_id;

        return $this;
    }
}