<?php

namespace QuadStudio\Service\Site\Filters\Address;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class AddressMapFilter extends Filter
{

    /**
     * @var array|null
     */
    private $accepts;

    /**
     * @var null|int
     */
    private $role_id;

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder
            ->where('type_id', 2)
            ->where(config('site.check_field'), 1)
            ->whereHas('users', function ($query) {
                $query
                    ->where('display', 1)
                    ->where('active', 1);
                if (!is_null($this->accepts) && !empty($this->accepts)) {
                    $query
                        ->join('authorization_accepts', 'authorization_accepts.user_id', '=', 'users.id')
                        ->join('authorization_types', 'authorization_types.id', '=', 'authorization_accepts.type_id')
                        ->where('authorization_types.brand_id', 1)
                        ->where('authorization_accepts.role_id', $this->role_id)
                        ->whereIn('authorization_accepts.type_id', $this->accepts);
                }
            })
            ->orderBy("addresses.region_id")
            ->orderBy("addresses.sort_order")
            ->orderBy("addresses.name");

        return $builder;
    }

    /**
     * @param array $accepts
     * @return $this
     */
    public function setAccepts(array $accepts = null)
    {
        $this->accepts = $accepts;

        return $this;
    }

    /**
     * @param null $role_id
     * @return $this
          */
    public function setRoleId($role_id = null)
    {
        $this->role_id = $role_id;

        return $this;
    }


}