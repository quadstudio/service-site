<?php

namespace QuadStudio\Service\Site\Filters\Order;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter;

class OrderIdSearchFilter extends SearchFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_order';

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack()) {
            if (!empty($this->columns())) {
                $words = $this->split($this->get($this->search));
                if (!empty($words)) {
                    foreach ($words as $word) {
                        $builder->where(function ($query) use ($word) {
                            foreach ($this->columns() as $column) {
                                $query->where($column, $word);
                            }
                        });
                    }
                }
            }
        }

        return $builder;
    }

    protected function columns()
    {
        return [
            'orders.id',
        ];
    }

    public function label()
    {
        return trans('site::order.placeholder.search_id');
    }

}