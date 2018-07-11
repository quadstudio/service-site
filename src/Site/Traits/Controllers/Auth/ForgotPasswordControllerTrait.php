<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Auth;

trait ForgotPasswordControllerTrait
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('site::auth.passwords.email');
    }

}