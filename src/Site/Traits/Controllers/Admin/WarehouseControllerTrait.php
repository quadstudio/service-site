<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Repositories\WarehouseRepository;
use QuadStudio\Service\Site\Models\Warehouse;

trait WarehouseControllerTrait
{

    protected $warehouses;

    /**
     * Create a new controller instance.
     *
     * @param WarehouseRepository $warehouses
     */
    public function __construct(WarehouseRepository $warehouses)
    {
        $this->warehouses = $warehouses;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->warehouses->trackFilter();
        return view('site::warehouse.index', [
            'repository' => $this->warehouses,
            'items'      => $this->warehouses->paginate(config('site.per_page.warehouse', 10), [env('DB_PREFIX', '').'warehouses.*'])
        ]);
    }

    public function show(Warehouse $warehouse)
    {
        return view('site::warehouse.show', ['warehouse' => $warehouse]);
    }
}