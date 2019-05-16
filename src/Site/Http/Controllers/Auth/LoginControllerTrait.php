<?php

namespace QuadStudio\Service\Site\Http\Controllers\Auth;


use Illuminate\Http\Request;

trait LoginControllerTrait
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

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

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password'        => 'required|string',
            'captcha'         => 'required|captcha',
        ], [
            'captcha' => trans('site::register.error.captcha')
        ]);
    }

    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'), ['active' => 1, 'verified' => 1]);
    }

}