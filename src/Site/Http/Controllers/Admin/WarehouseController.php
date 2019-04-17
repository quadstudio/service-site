<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Repositories\WarehouseRepository;
use QuadStudio\Service\Site\Models\Warehouse;

class WarehouseController extends Controller
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
        return view('site::admin.warehouse.index', [
            'repository' => $this->warehouses,
            'warehouses'      => $this->warehouses->paginate(config('site.per_page.warehouse', 10), ['warehouses.*'])
        ]);
    }

    public function show(Warehouse $warehouse)
    {
        return view('site::admin.warehouse.show', ['warehouse' => $warehouse]);
    }
}