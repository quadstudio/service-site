<?php

namespace QuadStudio\Service\Site\Filters\Datasheet;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filters\BootstrapInput;
use QuadStudio\Repo\Filters\SearchFilter as BaseFilter;

class SearchFilter extends BaseFilter
{

    use BootstrapInput;

    protected $render = true;
    protected $search = 'search_datasheet';

    function apply($builder, RepositoryInterface $repository)
    {
        if ($this->canTrack()) {
            $words = $this->split($this->get($this->search));
            if (!empty($words)) {
                $builder = $builder->where(function ($query) use ($words) {
                    foreach ($words as $word) {
                        $query->orWhereRaw("LOWER(name) LIKE LOWER(?)", ["%{$word}%"]);
                        $query->orWhereHas('file', function ($query) use ($word) {
                            $query->where(function ($query) use ($word) {
                                $query->orWhereRaw("LOWER(name) LIKE LOWER(?)", ["%{$word}%"]);
                            });
                        });
                        //});

                    }
                });

            }
        }
        //dump($builder->getBindings());
        //dd($builder->toSql());

        return $builder;
    }

    public function label()
    {
        return trans('site::datasheet.placeholder.search');
    }

    protected function attributes()
    {
        $attributes = parent::attributes();
        $attributes->put('style', 'min-width: 208px;');

        return $attributes;
    }

}