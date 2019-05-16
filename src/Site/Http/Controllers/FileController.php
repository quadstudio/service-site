<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Http\Requests\FileRequest;
use QuadStudio\Service\Site\Models\File;
use QuadStudio\Service\Site\Repositories\FileRepository;
use QuadStudio\Service\Site\Repositories\FileTypeRepository;
use Illuminate\Routing\Controller;

class FileController extends Controller
{

    use AuthorizesRequests;

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
            'items'      => $this->files->paginate(config('site.per_page.file', 10), ['files.*'])
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
            'path'    => Storage::disk($request->input('storage'))->putFile(config('site.files.path'), new \Illuminate\Http\File($f->getPathName())),
            'mime'    => $f->getMimeType(),
            'storage' => $request->input('storage'),
            'size'    => $f->getSize(),
            'name'    => $f->getClientOriginalName(),
        ]));

        $file->save();

        //ProcessFile::dispatch($file)->onQueue('images');

        return response()->json([
            'file' => view('site::file.create.card')
                ->with('file', $file)
                ->with('success', trans('site::file.loaded'))
                ->render(),
        ]);
    }

    public function show(File $file)
    {

        if (!is_null($file->fileable)) {
            $this->authorize('view', $file);
        }
        $file->increment('downloads');
        $file->update(['downloaded_at' => Carbon::now()]);

        return Storage::disk($file->storage)->download($file->path, $file->name);
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