<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Filters\CatalogEnabledFilter;
use QuadStudio\Service\Site\Http\Requests\CatalogRequest;
use QuadStudio\Service\Site\Models\Catalog;
use QuadStudio\Service\Site\Models\CatalogImage;
use QuadStudio\Service\Site\Repositories\CatalogImageRepository;
use QuadStudio\Service\Site\Repositories\CatalogRepository;

trait CatalogControllerTrait
{

    protected $catalogs;
    protected $images;

    /**
     * Create a new controller instance.
     *
     * @param CatalogRepository $catalogs
     * @param CatalogImageRepository $images
     */
    public function __construct(CatalogRepository $catalogs, CatalogImageRepository $images)
    {
        $this->catalogs = $catalogs;
        $this->images = $images;
    }

    /**
     * Каталог оборудования
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->catalogs->trackFilter();
        $this->catalogs->applyFilter(new CatalogEnabledFilter());

        return view('admin.catalog.index', [
            'repository' => $this->catalogs,
            'items'      => $this->catalogs->paginate(config('site.per_page.catalog', 10), [env('DB_PREFIX', '') . 'catalogs.*'])
        ]);
    }


    public function tree(){
        $tree = $this->catalogs->tree();
        return view('admin.catalog.tree', compact('tree'));
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
        $parent_catalog_id = !is_null($catalog) ? $catalog->id : null;
        $tree = $this->catalogs->tree();

        return view('admin.catalog.create', compact('images', 'parent_catalog_id', 'tree'));
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
                $redirect = redirect()->route('admin.catalogs.create.parent', Catalog::find($request->input('catalog_id')))->with('success', trans('site::catalog.created'));
            } else {
                $redirect = redirect()->route('admin.catalogs.create')->with('success', trans('site::catalog.created'));
            }
        } else {
            $redirect = redirect()->route('admin.catalogs.show', $catalog)->with('success', trans('site::catalog.created'));
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
     * Show the form for editing the specified resource.
     *
     * @param CatalogRequest $request
     * @param  Catalog $catalog
     * @return \Illuminate\Http\Response
     */
    public function edit(CatalogRequest $request, Catalog $catalog)
    {
        $this->authorize('update', $catalog);
        $tree = $this->catalogs->tree();
        $parent_catalog_id = null;
        $images = $this->getImages($request);
        $images = $images->merge($catalog->images);

        return view('admin.catalog.edit', compact('tree', 'images', 'catalog', 'parent_catalog_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CatalogRequest $request
     * @param  Catalog $catalog
     * @return \Illuminate\Http\Response
     */
    public function update(CatalogRequest $request, Catalog $catalog)
    {
        $this->authorize('update', $catalog);
        $this->catalogs->update(array_merge(
            $request->only(['name', 'name_plural', 'description', 'catalog_id']),
            ['enabled' => $request->filled('enabled') ? 1 : 0],
            ['model' => $request->filled('model') ? 1 : 0]
        ), $catalog->id);
        $this->setImages($request, $catalog);
        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('admin.catalogs.edit', $catalog)->with('success', trans('site::catalog.updated'));
        } else {
            $redirect = redirect()->route('admin.catalogs.show', $catalog)->with('success', trans('site::catalog.updated'));
        }

        return $redirect;
    }


    /**
     * Карточка каталога оборудования
     *
     * @param Catalog $catalog
     * @return \Illuminate\Http\Response
     */
    public function show(Catalog $catalog)
    {
        return view('admin.catalog.show', ['catalog' => $catalog]);
    }
}