<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Http\Request;
use QuadStudio\Service\Site\Http\Requests\EquipmentRequest;
use QuadStudio\Service\Site\Models;
use QuadStudio\Service\Site\Models\Equipment;
use QuadStudio\Service\Site\Repositories;
use QuadStudio\Service\Site\Traits\Support\ImageLoaderTrait;

trait EquipmentControllerTrait
{
    use ImageLoaderTrait;
    /**
     * @var Repositories\EquipmentRepository
     */
    protected $equipments;
    /**
     * @var Repositories\CatalogRepository
     */
    private $catalogs;
    /**
     * @var Repositories\ImageRepository
     */
    private $images;
    /**
     * @var Repositories\CurrencyRepository
     */
    private $currencies;

    /**
     * Create a new controller instance.
     *
     * @param Repositories\EquipmentRepository $equipments
     * @param Repositories\CatalogRepository $catalogs
     * @param Repositories\ImageRepository $images
     * @param Repositories\CurrencyRepository $currencies
     */
    public function __construct(
        Repositories\EquipmentRepository $equipments,
        Repositories\CatalogRepository $catalogs,
        Repositories\ImageRepository $images,
        Repositories\CurrencyRepository $currencies
    )
    {
        $this->equipments = $equipments;
        $this->catalogs = $catalogs;
        $this->images = $images;
        $this->currencies = $currencies;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->equipments->trackFilter();


        return view('site::admin.equipment.index', [
            'repository' => $this->equipments,
            'equipments' => $this->equipments->paginate(config('site.per_page.equipment', 10), ['equipments.*'])
        ]);
    }

    public function show(Models\Equipment $equipment)
    {

        return view('site::admin.equipment.show', ['equipment' => $equipment]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param EquipmentRequest $request
     * @param Models\Catalog|null $catalog
     * @return \Illuminate\Http\Response
     */
    public function create(EquipmentRequest $request, Models\Catalog $catalog = null)
    {

        $this->authorize('create', Models\Catalog::class);
        $images = $this->getImages($request);
        $currencies = $this->currencies->all();
        $parent_catalog_id = !is_null($catalog) ? $catalog->id : null;
        $tree = $this->catalogs->tree();

        return view('site::admin.equipment.create', compact('images', 'currencies', 'parent_catalog_id', 'tree'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  EquipmentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EquipmentRequest $request)
    {
        $this->authorize('create', Models\Equipment::class);
        //dd($request->all());
        $equipment = $this->equipments->create(array_merge(
            $request->except(['_token', '_method', '_create', 'image']),
            ['enabled' => $request->filled('enabled') ? 1 : 0]
        ));
        $this->setImages($request, $equipment);
        if ($request->input('_create') == 1) {
            if ($request->filled('catalog_id')) {
                $redirect = redirect()->route('admin.equipments.create.parent', Models\Catalog::find($request->input('catalog_id')))->with('success', trans('equipment::catalog.created'));
            } else {
                $redirect = redirect()->route('admin.equipments.create')->with('success', trans('equipment::catalog.created'));
            }
        } else {
            $redirect = redirect()->route('admin.equipments.show', $equipment)->with('success', trans('equipment::catalog.created'));
        }

        return $redirect;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EquipmentRequest $request
     * @param  Models\Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function edit(EquipmentRequest $request, Models\Equipment $equipment)
    {
        $this->authorize('update', $equipment);
        $images = $this->getImages($request);
        $images = $images->merge($equipment->images);

        $currencies = $this->currencies->all();
        $tree = $this->catalogs->tree();
        //dump($tree);

        return view('site::admin.equipment.edit', compact('images', 'currencies', 'tree', 'equipment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EquipmentRequest $request
     * @param  Models\Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function update(EquipmentRequest $request, Models\Equipment $equipment)
    {
        $this->authorize('update', $equipment);
        $this->equipments->update(array_merge(
            $request->except(['_token', '_method', '_stay', 'image']),
            ['enabled' => $request->filled('enabled') ? 1 : 0]
        ), $equipment->id);
        $this->setImages($request, $equipment);
        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('admin.equipments.edit', $equipment)->with('success', trans('site::catalog.updated'));
        } else {
            $redirect = redirect()->route('admin.equipments.show', $equipment)->with('success', trans('site::catalog.updated'));
        }

        return $redirect;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Equipment $equipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipment $equipment)
    {

        $this->authorize('delete', $equipment);

        if ($this->equipments->delete($equipment->id) > 0) {
            $redirect = route('admin.equipments.index');
        } else {
            $redirect = route('admin.equipments.show', $equipment);
        }
        $json['redirect'] = $redirect;

        return response()->json($json);

    }

}