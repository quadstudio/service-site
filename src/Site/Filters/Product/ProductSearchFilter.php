<?php

namespace QuadStudio\Service\Site\Filters\Product;

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
        if ($this->canTrack()) {
            if (!empty($this->columns())) {
                $words = $this->split($this->get($this->search));
                if (!empty($words)) {
                    foreach ($words as $product_id) {
                        $builder = $builder->whereHas('back_relations', function ($query) use ($product_id) {
                            $query->where(function ($query) use ($product_id) {
                                $query->whereId($product_id);
                            });
                        });
                    }
                } else{
                    $builder->whereRaw("false");
                }
            }
        } else{
            $builder->whereRaw("false");
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