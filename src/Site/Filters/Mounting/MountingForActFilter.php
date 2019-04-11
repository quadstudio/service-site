<?php

namespace QuadStudio\Service\Site\Filters\Mounting;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class MountingForActFilter extends Filter
{
    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder
            ->where("mountings.status_id", 2)
            ->whereNull('act_id')
            //->orderBy("mountings.contragent_id", 'ASC')
            ->orderBy("mountings.created_at", 'DESC');

        return $builder;
    }
}