<?php

namespace QuadStudio\Service\Site\Filters\Mounting;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter as BaseFilter;

class MountingClientSearchFilter extends BaseFilter
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
            }
        }

        return $builder;
    }

    protected function columns()
    {
        return [
            'mountings.client',
            'mountings.phone_primary',
            'mountings.phone_secondary',
            'mountings.address',
        ];
    }

    public function label()
    {
        return trans('site::mounting.placeholder.search_client');
    }

    public function tooltip()
    {
        return trans('site::mounting.help.search_client');
    }

}