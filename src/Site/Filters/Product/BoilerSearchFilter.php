<?php

namespace QuadStudio\Service\Site\Filters\Product;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter as BaseFilter;

class BoilerSearchFilter extends BaseFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_boiler';

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack()) {
            if (!empty($this->columns())) {
                $words = $this->split($this->get($this->search));

                if (!empty($words)) {
                    $builder = $builder
                        ->whereEnabled(1)
                        ->whereHas('equipment', function ($query) {
                            $query->whereEnabled(1);
                        })
                        ->where(function ($query) use ($words) {
                            foreach ($words as $word) {
                                foreach ($this->columns() as $column) {
                                    $query->orWhereRaw("LOWER({$column}) LIKE LOWER(?)", ["%{$word}%"]);
                                }
                            }
                        });
                } else{
                    $builder = $builder->whereRaw("false");
                }
            }
        } else{
            $builder = $builder->whereRaw("false");
        }

        return $builder;
    }

    protected function columns()
    {
        return [
            env('DB_PREFIX', '') . 'products.name',
            env('DB_PREFIX', '') . 'products.sku',
        ];
    }

    public function label()
    {
        return trans('site::product.search_placeholder');
    }

}