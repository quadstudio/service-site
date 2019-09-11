<?php

namespace QuadStudio\Service\Site\Concerns;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Contracts\Imageable;
use QuadStudio\Service\Site\Contracts\SingleImageable;
use QuadStudio\Service\Site\Http\Requests\ImageRequest;
use QuadStudio\Service\Site\Jobs\ProcessImage;
use QuadStudio\Service\Site\Models\Image;

trait StoreImages
{

	/**
	 * @param \QuadStudio\Service\Site\Http\Requests\ImageRequest $request
	 * @param \QuadStudio\Service\Site\Contracts\Imageable $imageable
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
    public function storeImages(ImageRequest $request, Imageable $imageable = null)
    {

        $file = $request->file('path');

        $image = new Image([
            'path'    => Storage::disk($request->input('storage'))->putFile('', new File($file->getPathName())),
            'mime'    => $file->getMimeType(),
            'storage' => $request->input('storage'),
            'size'    => $file->getSize(),
            'name'    => $file->getClientOriginalName(),
        ]);

        $mode = config("site.{$request->input('storage')}.mode");

        if ($mode == 'append' && !is_null($imageable)) {
            $image->setAttribute('sort_order', $imageable->images()->count());
            $imageable->images()->save($image);
        } else {
            $image->save();
        }

        ProcessImage::dispatch($image)->onQueue('images');

        return response()->json([
            $mode => [
                '#images' => view('site::admin.image.edit')
                    ->with('image', $image)
                    ->render(),
            ],
        ]);
    }

    /**
     * @param ImageRequest $request
     * @param Imageable $imageable
     * @return Collection|null
     */
    public function getImages(ImageRequest $request, Imageable $imageable = null)
    {

        return !empty($images = $request->old(config('site.' . $request->input('storage') . '.dot_name'))) ? Image::query()->findOrFail($images)->get() : ($imageable ? $imageable->images()->orderBy('sort_order')->get() : collect([]));
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @param \QuadStudio\Service\Site\Contracts\SingleImageable $imageable
     * @return Image
     */
    public function getImage(Request $request, SingleImageable $imageable = null)
    {
        $name = null;
        $image = null;
        if (!is_null($imageable)) {
            $name = config('site.' . $imageable->imageStorage() . '.dot_name');
        }

        if (!is_null($name) && $request->old($name)) {
            $image = Image::query()->findOrFail($request->old($name));
        } elseif (!is_null($imageable)) {
            $image = $imageable->image;
        }

        return $image;
    }
}