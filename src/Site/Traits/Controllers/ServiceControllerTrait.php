<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Repositories\ServiceRepository;
use QuadStudio\Service\Site\Models\Service;

trait ServiceControllerTrait
{

    protected $services;

    /**
     * Create a new controller instance.
     *
     * @param ServiceRepository $services
     */
    public function __construct(ServiceRepository $services)
    {
        $this->services = $services;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('site::service.index');
//        $this->services->trackFilter();
//        return view('site::service.index', [
//            'repository' => $this->services,
//            'items'      => $this->services->paginate(config('site.per_page.service', 10), [env('DB_PREFIX', '').'services.*'])
//        ]);
    }

    public function show(Service $service)
    {
        return view('site::service.show', ['service' => $service]);
    }
}