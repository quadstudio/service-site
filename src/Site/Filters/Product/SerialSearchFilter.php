<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter;

class SerialSearchFilter extends SearchFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_serial';

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack()) {
            if (!empty($this->columns())) {
                $words = $this->split($this->get($this->search));
                if (!empty($words)) {
                    foreach ($words as $serial) {
                        $builder = $builder->whereHas('back_relations', function ($query) use ($serial) {
                            $query->where(function ($query) use ($serial) {
                                $query->whereHas('serials', function ($query) use ($serial) {
                                    foreach ($this->columns() as $column) {
                                        $query->whereRaw("LOWER({$column}) = LOWER(?)", [$serial]);
                                    }
                                });
                            });
                        });
                    }
                } else{
                    $builder->whereRaw("false");
                }
            }
        }

        return $builder;
    }

    protected function columns()
    {
        return [
            env('DB_PREFIX', '') . 'serials.id',
        ];
    }

    public function label()
    {
        return trans('site::product.search_placeholder');
    }

}