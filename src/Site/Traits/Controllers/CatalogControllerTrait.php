<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

trait CatalogControllerTrait
{
    /**
     * Show the equipment index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('site::catalog.index');
    }

}