<?php

namespace QuadStudio\Service\Site\Traits\Support;

use Illuminate\Http\Request;
use QuadStudio\Service\Site\Contracts\Imageable;
use QuadStudio\Service\Site\Models\Image;
use QuadStudio\Service\Site\Repositories;

trait ImageLoaderTrait
{

    /**
     * @var Repositories\ImageRepository
     */
    private $images;


    /**
     * Create a new controller instance.
     *
     * @param Repositories\ImageRepository $images
     */
    public function __construct(Repositories\ImageRepository $images)
    {
        $this->images = $images;
    }

    /**
     * @param Request $request
     * @param Imageable $imageable
     * @return \Illuminate\Support\Collection
     */
    protected function getImages(Request $request, Imageable $imageable)
    {
        $images = $imageable->images()->orderBy('sort_order')->get();
        $old = $request->old('image');
        if (!is_null($old) && is_array($old)) {
            foreach ($old as $image_id) {
                $images->push(Image::findOrFail($image_id));
            }
        }

        return $images;
    }

    /**
     * @param Request $request
     * @param Imageable $imageable
     */
    protected function setImages(Request $request, Imageable $imageable)
    {
        $this->detachImages($imageable);

        if ($request->filled('image')) {
            foreach ($request->input('image') as $image_id) {
                $imageable->images()->save(Image::find($image_id));
            }

        }
    }

    private function detachImages(Imageable $imageable)
    {
        foreach ($imageable->images()->get() as $image) {
            $image->imageable_id = null;
            $image->imageable_type = null;
            $image->save();
        }
    }

}