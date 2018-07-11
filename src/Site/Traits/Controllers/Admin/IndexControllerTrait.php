<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Http\Request;

trait IndexControllerTrait
{
    /**
     * Show application index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('site::admin.index');
    }
}