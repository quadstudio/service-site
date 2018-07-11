<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Models\Service;
use QuadStudio\Service\Site\Repositories\ServiceRepository;

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
     * Show the user service
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->services->trackFilter();
        return view('site::admin.service.index', [
            'repository' => $this->services,
            'items'      => $this->services->paginate(config('site.per_page.service', 10), [env('DB_PREFIX', '').'services.*'])
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param Service $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('site::admin.service.show', ['service' => $service]);
    }
}