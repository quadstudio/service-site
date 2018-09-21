<?php

namespace QuadStudio\Service\Site\Filters\User;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter;

class ContactSearchFilter extends SearchFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_contact';

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack()) {
            if (!empty($this->columns())) {
                $words = $this->split($this->get($this->search));
                if (!empty($words)) {
                    $builder->whereHas('contacts', function ($query) use ($words) {
                        $query->where(function ($query) use ($words) {
                            foreach ($words as $word) {
                                $query->where(function ($query) use ($word) {
                                    foreach ($this->columns() as $column) {
                                        $query->orWhereRaw("LOWER({$column}) LIKE LOWER(?)", ["%{$word}%"]);
                                    }
                                });
                            }
                            $query->orWhere(function ($query) use ($words) {
                                $query->whereHas('phones', function ($query) use ($words) {
                                    foreach ($words as $word) {
                                        $query->where(function ($query) use ($word) {
                                            foreach ($this->phone_columns() as $column) {
                                                $query->orWhere($column, $word);
                                            }
                                        });
                                    }
                                });
                            });
                        });
                    });
                }
            }
        }

        return $builder;
    }

    protected function columns()
    {
        return [
            'contacts.name',
            'contacts.position',
            'contacts.web',
        ];
    }

    protected function phone_columns()
    {
        return [
            'phones.number',
        ];
    }

    public function label()
    {
        return trans('site::contact.placeholder.search');
    }

    public function tooltip()
    {
        return trans('site::contact.help.search');
    }

}