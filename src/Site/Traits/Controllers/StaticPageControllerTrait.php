<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

trait StaticPageControllerTrait
{
    /**
     * Show application index page
     *
     * @return \Illuminate\Http\Response
     */
    public function abouts()
    {
        return view('site::static.abouts');
    }

    /**
     * Show application index page
     *
     * @return \Illuminate\Http\Response
     */
    public function contacts()
    {
        return view('site::static.contacts');
    }

}
