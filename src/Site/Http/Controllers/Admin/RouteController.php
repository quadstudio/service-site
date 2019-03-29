<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

class RouteController extends Controller
{


    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routes = app()->make('router')->getRoutes();

        return view('site::admin.route.index', compact('routes'));
    }

}