<?php

namespace QuadStudio\Service\Site\Filters\Storehouse;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter;

class StorehouseUserSearchFilter extends SearchFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_user';

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack()) {
            if (!empty($this->columns())) {
                $words = $this->split($this->get($this->search));
                if (!empty($words)) {
                    foreach ($words as $word) {
                        $builder = $builder->whereHas('user', function ($query) use ($word) {
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
        return ['users.name'];
    }

    public function label()
    {
        return trans('site::storehouse.placeholder.search_user');
    }

    public function tooltip()
    {
        return trans('site::storehouse.help.search_user');
    }

}