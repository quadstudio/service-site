<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;


use QuadStudio\Service\Site\Models\Serial;
use QuadStudio\Service\Site\Repositories\SerialRepository;

trait SerialControllerTrait
{

    protected $serials;

    /**
     * Create a new controller instance.
     *
     * @param SerialRepository $serials
     */
    public function __construct(SerialRepository $serials)
    {
        $this->serials = $serials;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->serials->trackFilter();

        return view('site::admin.serial.index', [
            'repository' => $this->serials,
            'serials'    => $this->serials->paginate(config('site.per_page.serial', 10), ['serials.*'])
        ]);
    }

    public function show(Serial $serial)
    {
        return view('site::admin.serial.show', compact('serial'));
    }
}