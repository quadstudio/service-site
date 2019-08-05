<?php

namespace QuadStudio\Service\Site\Filters\Repair;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter;

class ContragentSearchFilter extends SearchFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_contragent';

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack()) {
            if (!empty($this->columns())) {
                $words = $this->split($this->get($this->search));
                if (!empty($words)) {
                    foreach ($words as $word) {
                        $builder = $builder->whereHas('contragent', function ($query) use ($word) {
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
            'contragents.name',
            'contragents.inn',
        ];
    }

    public function label()
    {
        return trans('site::contragent.placeholder.search');
    }

    public function tooltip()
    {
        return trans('site::contragent.help.search');
    }

}