<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Http\Requests\CatalogImageRequest;
use QuadStudio\Service\Site\Jobs\ProcessCatalogImage;
use QuadStudio\Service\Site\Models\CatalogImage;
use QuadStudio\Service\Site\Repositories\CatalogImageRepository;

trait CatalogImageControllerTrait
{

    protected $images;

    /**
     * Create a new controller instance.
     *
     * @param CatalogImageRepository $images
     */
    public function __construct(CatalogImageRepository $images)
    {
        $this->images = $images;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->images->trackFilter();

        return view('admin.catalog.image.index', [
            'repository' => $this->images,
            'items'      => $this->images->paginate(config('site.per_page.catalog_image', 10), [env('DB_PREFIX', '') . 'catalog_images.*'])
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  CatalogImageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CatalogImageRequest $request)
    {
        $this->authorize('create', CatalogImage::class);
        $f = $request->file('path');

        $image = new CatalogImage([
            'path' => Storage::disk('equipment')->putFile(config('site.files.path'), new \Illuminate\Http\File($f->getPathName())),
            'mime' => $f->getMimeType(),
            'size' => $f->getSize(),
            'name' => $f->getClientOriginalName(),
        ]);
        $image->save();
        ProcessCatalogImage::dispatch($image)->onQueue('images');

        return response()->json([
            'image' => view('site::admin.catalog.image')->with('image', $image)->render(),
        ]);
        //return redirect()->route($route)->with('success', trans('repair::repair.created'));
    }

    public function show(CatalogImage $image)
    {
        $this->authorize('view', $image);

        return Storage::disk('equipment')->download($image->path);
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param $image_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($image_id)
    {
        $json = [];
        if (CatalogImage::destroy($image_id) == 1) {
            $json['remove'][] = '#catalog-image-' . $image_id;
        }

        return response()->json($json);

    }
}