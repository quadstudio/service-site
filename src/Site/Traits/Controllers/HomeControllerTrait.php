<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use Illuminate\Http\Request;

trait HomeControllerTrait
{
    /**
     * Личный кабинет пользователя
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('site::home');
    }
}