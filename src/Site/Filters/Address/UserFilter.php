<?php

namespace QuadStudio\Service\Site\Filters\Address;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class UserFilter extends Filter
{

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    protected $addressable_type = 'morph';
    protected $addressable_id = 'key';
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
        if ($this->canTrack()) {
            $builder = $builder->whereHas($this->get($this->addressable_type), function ($query) {
                $query->where($this->get($this->addressable_type).'.id', $this->get($this->addressable_id));
            });
        }
        //dump($builder->getBindings());
        //dd($builder->toSql());
        return $builder;

    }

    public function track()
    {
        return [
            $this->addressable_type,
            $this->addressable_id,
        ];
    }

}