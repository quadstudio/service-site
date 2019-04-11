<?php

namespace QuadStudio\Service\Site\Concerns;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Contracts\Imageable;
use QuadStudio\Service\Site\Http\Requests\ImageRequest;
use QuadStudio\Service\Site\Models\Image;

trait StoreImages
{
    /**
     * @param \QuadStudio\Service\Site\Http\Requests\ImageRequest $request
     * @param \QuadStudio\Service\Site\Contracts\Imageable $imageable
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeImage(ImageRequest $request, Imageable $imageable)
    {
        $file = $request->file('path');

        $image = new Image([
            'path'    => Storage::disk($request->input('storage'))->putFile('', new File($file->getPathName())),
            'mime'    => $file->getMimeType(),
            'storage' => $request->input('storage'),
            'size'    => $file->getSize(),
            'name'    => $file->getClientOriginalName(),
        ]);

        $imageable->images()->save($image);

        return response()->json([
            config('site.' . $request->input('storage') . '.method', 'append') => [
                '#images' => view('site::admin.image.edit')
                    ->with('image', $image)
                    ->render()
            ]
        ]);
    }

    /**
     * @param ImageRequest $request
     * @param Imageable $imageable
     * @return Image
     */
    public function getImage(ImageRequest $request, Imageable $imageable = null)
    {
        return !is_null($image_id = $request->old(config('site.' . $request->input('storage') . '.dot_name'))) ? Image::findOrFail($image_id) : ($imageable ? $imageable->images()->first() : null);
    }

    /**
     * @param FileRequest $request
     * @param SingleFileable $fileable
     */
    protected function setFile(FileRequest $request, SingleFileable $fileable)
    {
        if ($request->filled('file_id')) {
            $fileable->file()->associate(File::find($request->input('file_id')));
        }
    }
}