<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Concerns\StoreFiles;
use QuadStudio\Service\Site\Contracts\Fileable;
use QuadStudio\Service\Site\Http\Requests\FileRequest;
use QuadStudio\Service\Site\Models\File;

class FileController extends Controller
{

    use StoreFiles;

    /**
     * Store a newly created resource in storage.
     *
     * @param  FileRequest $request
     * @param Fileable $fileable
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FileRequest $request, Fileable $fileable = null)
    {
        //dd($request->all());
        return $this->storeFiles($request, $fileable);

    }

    public function show(File $file)
    {
        return Storage::disk($file->getAttribute('storage'))->download($file->getAttribute('path'), $file->getAttribute('name'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param File $file
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(File $file)
    {
        $json = [];
        if ($file->delete()) {
            $json['remove'][] = '#file-' . $file->getAttribute('id');
        }

        return response()->json($json);

    }
}