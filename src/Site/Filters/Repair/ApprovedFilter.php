<?php

namespace QuadStudio\Service\Site\Filters\Repair;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class ApprovedFilter extends Filter
{
    private $prefix;

    public function __construct($params = [])
    {
        parent::__construct($params);
        $this->prefix = env('DB_PREFIX', '');
    }

    function apply($builder, RepositoryInterface $repository)
    {
        $builder = $builder
            ->where("{$this->prefix}repairs.status_id", 5)
            ->join("{$this->prefix}users", "{$this->prefix}repairs.user_id", '=', "{$this->prefix}users.id")
            ->orderBy("{$this->prefix}users.name");

        return $builder;
    }
}