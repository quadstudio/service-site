<?php

namespace QuadStudio\Service\Site\Concerns;

use Illuminate\Http\File as HttpFile;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Contracts\Fileable;
use QuadStudio\Service\Site\Contracts\SingleFileable;
use QuadStudio\Service\Site\Http\Requests\FileRequest;
use QuadStudio\Service\Site\Models\File;

trait StoreFiles
{
    /**
     * @param \QuadStudio\Service\Site\Http\Requests\FileRequest $request
     * @param \QuadStudio\Service\Site\Contracts\Fileable $fileable
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeFiles(FileRequest $request, Fileable $fileable = null)
    {

        $file = $request->file('path');

        $model = new File([
            'path'    => Storage::disk($request->input('storage'))->putFile('', new HttpFile($file->getPathName())),
            'mime'    => $file->getMimeType(),
            'storage' => $request->input('storage'),
            'type_id' => $request->input('type_id'),
            'size'    => $file->getSize(),
            'name'    => $file->getClientOriginalName(),
        ]);

        $mode = config("site.{$request->input('storage')}.mode");

        if ($mode == 'append' && !is_null($fileable)) {
            $fileable->files()->save($model);
        } else {
            $model->save();
        }

        return response()->json([
            $mode => [
                '#files' => view('site::admin.file.edit')
                    ->with('file', $model)
                    ->render(),
            ],
        ]);
    }

    /**
     * @param FileRequest $request
     * @param Fileable $fileable
     * @return Collection
     */
    public function getFiles(FileRequest $request, Fileable $fileable = null)
    {

        return !empty($files = $request->old(config('site.' . $request->input('storage') . '.dot_name'))) ? File::query()->findOrFail($files)->get() : ($fileable ? $fileable->files()->orderBy('sort_order')->get() : collect([]));
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @param \QuadStudio\Service\Site\Contracts\SingleFileable $fileable
     * @return File
     */
    public function getFile(Request $request, SingleFileable $fileable = null)
    {
        $name = null;
        $model = null;
        if (!is_null($fileable)) {
            $name = config('site.' . $fileable->fileStorage() . '.dot_name');
        }

        if (!is_null($name) && $request->old($name)) {
            $model = File::query()->findOrFail($request->old($name));
        } elseif (!is_null($fileable)) {
            $model = $fileable->file()->first();
        }

        return $model;
    }

}