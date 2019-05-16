<?php

namespace QuadStudio\Service\Site\Filters\Member;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter as BaseFilter;

class MemberSearchCityFilter extends BaseFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_city';

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
            'members.city',
            'members.address'
        ];
    }

    public function label()
    {
        return trans('site::member.placeholder.search_address');
    }

    public function tooltip()
    {
        return false;
    }

}