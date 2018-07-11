<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait LoginControllerTrait
{

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('site::auth.login');
    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectTo()
    {
        return app('site')->isAdmin() ? route('admin') : route('home');
    }

    protected function credentials(Request $request) {
        return array_merge($request->only($this->username(), 'password'), ['active' => 1, 'verified' => 1]);
    }

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

}