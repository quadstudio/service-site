<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Http\Requests\FileRequest;
use QuadStudio\Service\Site\Jobs\ProcessFile;
use QuadStudio\Service\Site\Models\File;
use QuadStudio\Service\Site\Repositories\FileRepository;
use QuadStudio\Service\Site\Repositories\FileTypeRepository;

trait FileControllerTrait
{

    protected $files;
    protected $types;

    /**
     * Create a new controller instance.
     *
     * @param FileRepository $files
     * @param FileTypeRepository $types
     */
    public function __construct(FileRepository $files, FileTypeRepository $types)
    {
        $this->files = $files;
        $this->types = $types;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->types->trackFilter();

        return view('site::repair.index', [
            'repository' => $this->files,
            'items'      => $this->files->paginate(config('site.per_page.file', 10), [env('DB_PREFIX', '') . 'files.*'])
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  FileRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileRequest $request)
    {
        $this->authorize('create', File::class);
        $f = $request->file('path');
        $file = new File(array_merge($request->only(['type_id']), [
            'path' => Storage::disk('files')->putFile(config('site.files.path'), new \Illuminate\Http\File($f->getPathName())),
            'mime' => $f->getMimeType(),
            'storage' => $request->input('storage'),
            'size' => $f->getSize(),
            'name' => $f->getClientOriginalName(),
        ]));
        $file->save();
        ProcessFile::dispatch($file)->onQueue('images');

        return response()->json([
            'file' => view('site::file.file')->with('file', $file)->render(),
        ]);
        //return redirect()->route($route)->with('success', trans('repair::repair.created'));
    }

    public function show(File $file)
    {
        $this->authorize('view', $file);
        return Storage::disk($file->storage)->download($file->path);
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
        $file_id = $file->id;
        if ($file->delete()) {
            $json['remove'][] = '#file-' . $file_id;
        }

        return response()->json($json);

    }
}