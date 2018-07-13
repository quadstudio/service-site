<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Http\Requests\CatalogRequest;
use QuadStudio\Service\Site\Models\Catalog;
use QuadStudio\Service\Site\Models\CatalogImage;
use QuadStudio\Service\Site\Models\Equipment;
use QuadStudio\Service\Site\Repositories\CatalogImageRepository;
use QuadStudio\Service\Site\Repositories\CatalogRepository;
use QuadStudio\Service\Site\Repositories\EquipmentRepository;

trait EquipmentControllerTrait
{
    /**
     * @var EquipmentRepository
     */
    protected $equipments;
    /**
     * @var CatalogRepository
     */
    private $catalogs;
    /**
     * @var CatalogImageRepository
     */
    private $images;

    /**
     * Create a new controller instance.
     *
     * @param EquipmentRepository $equipments
     * @param CatalogRepository $catalogs
     * @param CatalogImageRepository $images
     */
    public function __construct(
        EquipmentRepository $equipments,
        CatalogRepository $catalogs,
        CatalogImageRepository $images
    )
    {
        $this->equipments = $equipments;
        $this->catalogs = $catalogs;
        $this->images = $images;
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
            'equipments' => $this->equipments->paginate(config('site.per_page.equipment', 10), [env('DB_PREFIX', '') . 'equipments.*'])
        ]);
    }

    public function show(Equipment $equipment)
    {
        return view('site::equipment.show', ['equipment' => $equipment]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CatalogRequest $request
     * @param Catalog|null $catalog
     * @return \Illuminate\Http\Response
     */
    public function create(CatalogRequest $request, Catalog $catalog = null)
    {
        $this->authorize('create', Catalog::class);
        $images = $this->getImages($request);
        $catalog_id = !is_null($catalog) ? $catalog->id : null;
        $tree = $this->catalogs->tree();

        return view('admin.catalog.create', compact('images', 'catalog_id', 'tree'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CatalogRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CatalogRequest $request)
    {
        $this->authorize('create', Catalog::class);
        //dd($request->all());
        $catalog = $this->catalogs->create(array_merge(
            $request->except(['_token', '_method', '_create', 'image']),
            ['enabled' => $request->filled('enabled') ? 1 : 0],
            ['model' => $request->filled('model') ? 1 : 0]
        ));
        $this->setImages($request, $catalog);
        if ($request->input('_create') == 1) {
            if ($request->filled('catalog_id')) {
                $redirect = redirect()->route('admin.catalogs.create.parent', Catalog::find($request->input('catalog_id')))->with('success', trans('equipment::catalog.created'));
            } else {
                $redirect = redirect()->route('admin.catalogs.create')->with('success', trans('equipment::catalog.created'));
            }
        } else {
            $redirect = redirect()->route('admin.catalogs.show', $catalog)->with('success', trans('equipment::catalog.created'));
        }

        return $redirect;
    }

    private function setImages(CatalogRequest $request, Catalog $catalog)
    {

        //$catalog->images->update(['catalog_id' => null]);
        if ($request->filled('image')) {
            foreach ($request->input('image') as $image_id) {
                $this->images->update(['catalog_id' => $catalog->id], $image_id);
            }
        }

        $this->images->deleteLostImages();
    }

    /**
     * @param CatalogRequest $request
     * @return \Illuminate\Support\Collection
     */
    private function getImages(CatalogRequest $request)
    {
        $images = collect([]);
        $old = $request->old('image');
        if (!is_null($old) && is_array($old)) {
            foreach ($old as $image_id) {
                $images->push(CatalogImage::findOrFail($image_id));
            }
        }

        return $images;
    }
}