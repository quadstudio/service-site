<?php

namespace QuadStudio\Service\Site\Filters\FileType;

use QuadStudio\Repo\Contracts\RepositoryInterface;
use QuadStudio\Repo\Filter;

class ModelHasFilesFilter extends Filter
{
    /**
     * @var null
     */
    private $id;

    /**
     * @var  string
     */
    private $morph;

    function apply($builder, RepositoryInterface $repository)
    {
        if (!is_null($this->id) && !is_null($this->morph)) {
            $builder = $builder->whereHas('files', function ($file) {
                $file->whereFileableId($this->id)->whereFileableType($this->morph);
            });
        } else {
            $builder->whereRaw('false');
        }
        return $builder;
    }

    /**
     * @param string|int $id
     * @return $this
     */
    public function setId($id = null)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $morph
     * @return $this
     */
    public function setMorph($morph = null)
    {
        $this->morph = $morph;

        return $this;
    }

}