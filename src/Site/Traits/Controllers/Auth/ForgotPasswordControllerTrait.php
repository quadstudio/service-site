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
     * Показать форму для сброса пароля
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('site::auth.passwords.email');
    }

    /**
     * Получить ответ при успешном сбросе пароля
     *
     * @param  string $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse($response)
    {
        return redirect()->route('login')->with('success', trans($response));
    }

}