<?php

namespace QuadStudio\Service\Site\Repositories;

use QuadStudio\Repo\Eloquent\Repository;
use QuadStudio\Service\Site\Filters\LostCatalogImageFilter;
use QuadStudio\Service\Site\Models\Image;

class ImageRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Image::class;
    }

    /**
     * @return array
     */
    public function track(): array
    {
        return [

        ];
    }

    public function deleteLostImages()
    {
        $this->applyFilter(new LostCatalogImageFilter());
        foreach ($this->all() as $image) {
            $this->delete($image->id);
        }
    }
}