<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\EnabledFilter;
use QuadStudio\Service\Site\Models\Datasheet;
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
        if($equipment->enabled == 0){
            abort(404);
        }
        $products = $equipment->products()->where('enabled', 1)->orderBy('name')->get();
        $datasheets = Datasheet::where('active', 1)->whereHas('products', function($query) use ($equipment){
            $query->where('enabled', 1)->where('equipment_id', $equipment->id);
        })->get();
        return view('site::equipment.show', compact('equipment', 'products', 'datasheets'));
    }
}