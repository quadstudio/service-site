<?php

namespace QuadStudio\Service\Site\Filters\Service;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;
use QuadStudio\Service\Site\Models\Region;

class RegionFilter extends Filter
{
    /**
     * @var Region|null
     */
    private $region;

    function apply($builder, RepositoryInterface $repository)
    {
        if (!is_null($this->region)) {
            $builder = $builder->whereHas('addresses', function ($query) {
                $query->where(env('DB_PREFIX', '') . 'addresses.region_id', $this->region->id);
            });
        } else {
            $builder->whereRaw('false');
        }
        return $builder;
    }

    /**
     * @param Region $region
     * @return $this
     */
    public function setRegion(Region $region = null)
    {
        $this->region = $region;

        return $this;
    }
}