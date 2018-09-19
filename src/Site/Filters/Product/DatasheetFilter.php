<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class DatasheetFilter extends Filter
{

    /**
     * @param $builder
     * @param RepositoryInterface $repository
     * @return mixed
     */
    function apply($builder, RepositoryInterface $repository)
    {

        if ($this->canTrack() && $this->filled($this->name())) {

            $builder = $builder->whereHas('datasheets', function ($query) {
                $datasheet_id = $this->get($this->name());
                $query->where('id', $datasheet_id);
            });
        }

        return $builder;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'datasheet_id';
    }

}