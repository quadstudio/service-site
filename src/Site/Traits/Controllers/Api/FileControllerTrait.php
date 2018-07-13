<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;

use QuadStudio\Service\Site\Http\Resources\FileCollection;
use QuadStudio\Service\Site\Http\Resources\FileResource;
use QuadStudio\Service\Site\Models\File;
use QuadStudio\Service\Site\Repositories\FileRepository;

trait FileControllerTrait
{
    protected $files;

    /**
     * Create a new controller instance.
     *
     * @param FileRepository $files
     */
    public function __construct(FileRepository $files)
    {
        $this->files = $files;
    }

    /**
     * @return FileCollection
     */
    public function index()
    {
        return new FileCollection($this->files->all());
    }

    /**
     * Display the specified resource.
     *
     * @param File $file
     * @return FileResource
     */
    public function show(File $file)
    {
        return new FileResource($file);
    }
}