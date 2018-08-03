<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class AddressableFilter extends Filter
{

    /**
     * @var null
     */
    private $id;

    /**
     * @var  string
     */
    private $morph;

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder->whereAddressableId($this->id)->whereAddressableType($this->morph);

        //$builder = $builder->where($repository->getTable().'.user_id', Auth::user()->getAuthIdentifier());
        return $builder;
    }

    /**
     * @param string|int $id
     * @return $this
     */
    public function setId($id = null)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $morph
     * @return $this
     */
    public function setMorph($morph = null)
    {
        $this->morph = $morph;

        return $this;
    }
}