<?php

namespace QuadStudio\Service\Site\Filters\Address;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class AddressMounterFilter extends Filter
{

    /**
     * @var array|null
     */
    private $accepts;

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder
            ->where('is_mounter', 1)
            ->where(config('site.check_field'), 1)
            ->whereHas('users', function ($query) {
                $query
                    ->where('display', 1)
                    ->where('active', 1);
                if (!is_null($this->accepts) && !empty($this->accepts)) {
                    $query
                        ->join('authorization_accepts', 'authorization_accepts.user_id', '=', 'users.id')
                        ->join('authorization_types', 'authorization_types.id', '=', 'authorization_accepts.type_id')
                        ->where('authorization_accepts.role_id', 4)
                        ->where('authorization_types.brand_id', config('site.brand_default'))
                        ->whereIn('authorization_accepts.type_id', $this->accepts);
                }
            });

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

}