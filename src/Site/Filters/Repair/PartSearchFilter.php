<?php

namespace QuadStudio\Service\Site\Filters\Repair;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter;

class PartSearchFilter extends SearchFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_part';

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack()) {
            if (!empty($this->columns())) {
                $words = $this->split($this->get($this->search));
                if (!empty($words)) {
                    foreach ($words as $word) {
                        $builder->whereHas('parts', function ($query) use ($word) {
                            $query->whereHas('product', function ($query) use ($word) {
                                $query->where(function ($query) use ($word) {
                                    foreach ($this->columns() as $column) {
                                        $query->orWhereRaw("LOWER({$column}) LIKE LOWER(?)", ["%{$word}%"]);
                                    }
                                });
                            });
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
            'products.sku',
            'products.name',
        ];
    }

    public function label()
    {
        return trans('site::repair.placeholder.search_part');
    }

    public function tooltip()
    {
        return trans('site::repair.help.search_part');
    }

}