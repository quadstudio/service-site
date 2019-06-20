<?php

namespace QuadStudio\Service\Site\Filters\Product;

use Illuminate\Support\Facades\DB;
use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class ProductMounterFilter extends Filter
{

    /**
     * @param $builder
     * @param RepositoryInterface $repository
     * @return mixed
     */
    function apply($builder, RepositoryInterface $repository)
    {

        if ($this->canTrack()) {
            if( $this->filled($this->name())){
                $builder = $builder->mounter()->where('equipment_id', $this->get($this->name()));
            } else{
                $builder = $builder->where(DB::raw(0),DB::raw(1));
            }
        } else{
            $builder = $builder->where(DB::raw(0),DB::raw(1));
        }

        return $builder;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'equipment_id';
    }

}