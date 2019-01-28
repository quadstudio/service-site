<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Http\Requests\ImageRequest;
use QuadStudio\Service\Site\Jobs\ProcessImage;
use QuadStudio\Service\Site\Models\Image;
use QuadStudio\Service\Site\Repositories\ImageRepository;

trait ImageControllerTrait
{

    protected $images;

    /**
     * Create a new controller instance.
     *
     * @param ImageRepository $images
     */
    public function __construct(ImageRepository $images)
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

        return view('admin.image.index', [
            'repository' => $this->images,
            'items'      => $this->images->paginate(config('site.per_page.image', 10), ['images.*'])
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  ImageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request)
    {

        $this->authorize('create', Image::class);
        $file = $request->file('path');

        $image = new Image([
            'path' => Storage::disk($request->input('storage'))->putFile('', new File($file->getPathName())),
            'mime' => $file->getMimeType(),
            'storage' => $request->input('storage'),
            'size' => $file->getSize(),
            'name' => $file->getClientOriginalName(),
        ]);

        $image->save();
        ProcessImage::dispatch($image, $request->input('storage'))->onQueue('images');

        return response()->json([
            'image' => view('site::admin.image.image', ['image'   => $image])->render(),
        ]);
    }

    public function show(Image $image)
    {
        $this->authorize('view', $image);

        return Storage::disk($image->getAttribute('storage'))->download($image->getAttribute('path'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ImageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function field(ImageRequest $request)
    {

        $this->authorize('create', Image::class);
        $file = $request->file('path');

        $image = new Image([
            'path'    => Storage::disk($request->input('storage'))->putFile('', new File($file->getPathName())),
            'mime'    => $file->getMimeType(),
            'storage' => $request->input('storage'),
            'size'    => $file->getSize(),
            'name'    => $file->getClientOriginalName(),
        ]);

        $image->save();

        return response()->json([
            'update' => [
                '#image-src' => view('site::admin.image.field', ['image' => $image])->render()
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Image $image
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Image $image)
    {
        $json = [];
        $image_id = $image->id;
        if ($image->delete()) {
            $json['remove'][] = '#image-' . $image_id;
        }

        return response()->json($json);

    }
}