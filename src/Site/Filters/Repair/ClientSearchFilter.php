<?php

namespace QuadStudio\Service\Site\Filters\Repair;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter as BaseFilter;

class ClientSearchFilter extends BaseFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_client';

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack()) {
            if (!empty($this->columns())) {
                $words = $this->split($this->get($this->search));
                if (!empty($words)) {
                    foreach ($words as $word) {
                        $builder = $builder->where(function ($query) use ($word) {
                            foreach ($this->columns() as $column) {
                                $query->orWhereRaw("LOWER({$column}) LIKE LOWER(?)", ["%{$word}%"]);
                            }
                        });
                    }
                }
//                else{
//                    $builder->whereRaw("false");
//                }
            }
        }

        return $builder;
    }

    protected function columns()
    {
        return [
            env('DB_PREFIX', '') . 'repairs.client',
            env('DB_PREFIX', '') . 'repairs.phone_primary',
            env('DB_PREFIX', '') . 'repairs.phone_secondary',
            env('DB_PREFIX', '') . 'repairs.address',
        ];
    }

    public function label()
    {
        return trans('site::repair.placeholder.search_client');
    }

    public function tooltip()
    {
        return trans('site::repair.help.search_client');
    }

}