<?php

namespace QuadStudio\Service\Site\Traits\Support;

use Illuminate\Http\File as BaseFile;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Contracts\SingleFileable;
use QuadStudio\Service\Site\Http\Requests\FileRequest;
use QuadStudio\Service\Site\Models\File;

trait SingleFileLoaderTrait
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  FileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function file(FileRequest $request)
    {

        $path = $request->file('path');
        $file = new File([
            'path'    => Storage::disk($request->input('storage'))->putFile('', new BaseFile($path->getPathName())),
            'mime'    => $path->getMimeType(),
            'storage' => $request->input('storage'),
            'type_id' => $request->input('type_id'),
            'size'    => $path->getSize(),
            //'name'    => $path->getClientOriginalName(),
            'name'    => pathinfo($path->getClientOriginalName(), PATHINFO_FILENAME),
        ]);

        $file->save();

        return response()->json([
            'update' => [
                $request->input('preview') => view('site::admin.file.preview', ['file' => $file])->render()
            ]
        ]);
    }

    /**
     * @param FileRequest $request
     * @param SingleFileable $fileable
     * @return File
     */
    public function getFile(FileRequest $request, SingleFileable $fileable = null)
    {
        return !is_null($file_id = $request->old('file_id')) ? File::findOrFail($file_id) : ($fileable ? $fileable->file()->first() : null);
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