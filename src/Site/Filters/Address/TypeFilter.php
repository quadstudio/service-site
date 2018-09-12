<?php

namespace QuadStudio\Service\Site\Filters\Address;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class TypeFilter extends Filter
{
    /**
     * @var int|null
     */
    private $type_id;

    function apply($builder, RepositoryInterface $repository)
    {
        if (!is_null($this->type_id)) {
            $builder = $builder->where('type_id', $this->type_id)->where('addressable_type', 'users');
        } else {
            $builder->whereRaw('false');
        }
        return $builder;
    }

    /**
     * @param int $type_id
     * @return $this
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;

        return $this;
    }
}