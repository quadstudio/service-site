<?php

namespace QuadStudio\Service\Site\Filters;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\SearchFilter;
use QuadStudio\Repo\Filters\BootstrapInput;

class OrderSearchFilter extends SearchFilter
{

    use BootstrapInput;

    protected $render = true;

    public function label()
    {
        return trans('site::order.search_placeholder');
    }

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack()) {
            if (!empty($this->columns())) {
                $words = $this->split($this->get($this->search));
                if (!empty($words)) {
                    $builder->whereHas('items', function ($query) use ($words) {
                        foreach ($words as $word) {
                            $query->where(function ($query) use ($word) {
                                foreach ($this->columns() as $column){
                                    $query->orWhereRaw("LOWER({$column}) LIKE LOWER(?)", ["%{$word}%"]);
                                }
                            });
                        }
                    });
                }
            }
        }

        return $builder;
    }

    protected function columns()
    {
        return [
            'name',
            'sku'
        ];
    }

}