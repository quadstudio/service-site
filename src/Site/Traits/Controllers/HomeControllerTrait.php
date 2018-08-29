<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Http\Requests\ImageRequest;
use QuadStudio\Service\Site\Jobs\ProcessLogo;
use QuadStudio\Service\Site\Models\Image;

trait HomeControllerTrait
{
    /**
     * Личный кабинет пользователя
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (app('site')->isAdmin()) {
            return redirect()->route('admin');
        }
        $user = Auth::user();

        return view('site::home', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ImageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function logo(ImageRequest $request)
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
        $request->user()->image()->delete();

        $request->user()->image()->associate($image);

        $request->user()->save();

        ProcessLogo::dispatch($image, $request->input('storage'))->onQueue('images');

        return response()->json([
            'src' => Storage::disk($request->input('storage'))->url($image->path)
        ]);
    }
}