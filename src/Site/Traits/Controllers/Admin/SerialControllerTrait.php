<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Repositories\SerialRepository;
use QuadStudio\Service\Site\Models\Serial;

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
        return view('site::serial.index', [
            'repository' => $this->serials,
            'items'      => $this->serials->paginate(config('site.per_page.serial', 10), [env('DB_PREFIX', '').'serials.*'])
        ]);
    }

    public function show(Serial $serial)
    {
        return view('site::serial.show', ['serial' => $serial]);
    }
}