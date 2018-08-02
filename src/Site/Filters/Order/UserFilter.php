<?php

namespace QuadStudio\Service\Site\Filters\Order;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;
use QuadStudio\Service\Site\Models\User;

class UserFilter extends Filter
{
    /**
     * @var User|null
     */
    private $user;

    function apply($builder, RepositoryInterface $repository)
    {
        if (!is_null($this->user)) {
            $builder = $builder->whereUserId($this->user->id);
        } else {
            $builder->whereRaw('false');
        }
        return $builder;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }
}