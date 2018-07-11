<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Repositories\EquipmentRepository;
use QuadStudio\Service\Site\Models\Equipment;

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
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->equipments->trackFilter();
        return view('site::equipment.index', [
            'repository' => $this->equipments,
            'items'      => $this->equipments->paginate(config('site.per_page.equipment', 10), [env('DB_PREFIX', '').'equipments.*'])
        ]);
    }

    public function show(Equipment $equipment)
    {
        return view('site::equipment.show', ['equipment' => $equipment]);
    }
}