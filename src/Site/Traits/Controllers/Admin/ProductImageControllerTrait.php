<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Http\Requests\ImageRequest;
use QuadStudio\Service\Site\Jobs\ProcessImage;
use QuadStudio\Service\Site\Models\Image;
use QuadStudio\Service\Site\Models\Product;


trait ProductImageControllerTrait
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  ImageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request, Product $product)
    {

        $file = $request->file('path');

        $image = new Image([
            'path'    => Storage::disk($request->input('storage'))->putFile('', new File($file->getPathName())),
            'mime'    => $file->getMimeType(),
            'storage' => $request->input('storage'),
            'size'    => $file->getSize(),
            'name'    => $file->getClientOriginalName(),
        ]);

        $image->save();

        ProcessImage::dispatch($image, $request->input('storage'))->onQueue('images');

        $product->images()->save($image);

        return response()->json([
            'append' => [
                '#sort-list' => view('site::admin.product.show.image', ['image' => $image])->render()
            ],
            'update' => [
                '#images-count' => $product->images()->count()
            ]
        ]);
    }

    public function sort(Request $request, Product $product)
    {
        $sort = array_flip($request->input('sort'));
        /** @var Image $image */
        foreach ($product->images as $image) {
            $image->setAttribute('sort_order', $sort[$image->getKey()]);
            $image->save();
        }
    }
}