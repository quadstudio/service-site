<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\EnabledFilter;
use QuadStudio\Service\Site\Models\Equipment;
use QuadStudio\Service\Site\Repositories\EquipmentRepository;

trait EquipmentControllerTrait
{
    protected $equipments;

    /**
     * Create a new controller instance.
     *
     * @param EquipmentRepository $equipments
     */
    public function __construct(EquipmentRepository $equipments)
    {
        $this->equipments = $equipments;
    }

    /**
     * Show the equipment index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->equipments->trackFilter();
        $this->equipments->applyFilter(new EnabledFilter());

        return view('site::equipment.index', [
            'equipments' => $this->equipments->all([env('DB_PREFIX', '') . 'equipments.*'])
        ]);
    }

    public function show(Equipment $equipment)
    {
        return view('site::equipment.show', ['equipment' => $equipment]);
    }

}