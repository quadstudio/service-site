<?php

namespace QuadStudio\Service\Site\Filters\Address;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class AddressAcceptMapFilter extends Filter
{
    /**
     * @var array|null
     */
    private $accepts;

    function apply($builder, RepositoryInterface $repository)
    {
        if (!is_null($this->accepts) && !empty($this->accepts)) {
            $builder->where('addressable_type', '"users"')
                ->join('users', 'users.id', '=', 'addresses.addressable_id')
            ->whereHas('users', function ($query){
                dd($query->get());
                $query->authorization_accepts->where('role_id', 3)->whereHas('type', function($query){
                    $query->where('brand_id', 1)
                    ->whereIn('type_id', $this->accepts);
                });
            });
        }

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