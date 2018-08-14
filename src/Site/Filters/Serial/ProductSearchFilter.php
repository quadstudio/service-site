<?php

namespace QuadStudio\Service\Site\Filters\Serial;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter;

class ProductSearchFilter extends SearchFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_product';

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack() && $this->filled($this->search)) {
            if (!empty($this->columns())) {
                $words = $this->split($this->get($this->search));
                if (!empty($words)) {
                    foreach ($words as $word) {
                        $builder = $builder->whereHas('product', function ($query) use ($word) {
                            $query->where(function ($query) use ($word) {
                                foreach ($this->columns() as $column) {
                                    $query->orWhereRaw("LOWER({$column}) LIKE LOWER(?)", ["%{$word}%"]);
                                }
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
            env('DB_PREFIX', '') . 'products.id',
            env('DB_PREFIX', '') . 'products.sku',
            env('DB_PREFIX', '') . 'products.name',
        ];
    }

    public function label()
    {
        return trans('site::serial.placeholder.search_product');
    }

}