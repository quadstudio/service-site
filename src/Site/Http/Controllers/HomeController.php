<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Http\Requests\ImageRequest;
use QuadStudio\Service\Site\Jobs\ProcessLogo;
use QuadStudio\Service\Site\Models\AuthorizationRole;
use QuadStudio\Service\Site\Models\Image;

class HomeController extends Controller
{

    use AuthorizesRequests, ValidatesRequests;

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
        $authorization_roles = AuthorizationRole::query()->get();

        return view('site::home', compact('user', 'authorization_roles'));
    }

    /**
     * Логин под администратором
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function force(User $user, Request $request)
    {

        if (in_array($request->ip(), config('site.admin_ip'))) {
            Auth::guard()->logout();

            $request->session()->invalidate();

            Auth::login($user);

            return redirect()->route('admin');
        }


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