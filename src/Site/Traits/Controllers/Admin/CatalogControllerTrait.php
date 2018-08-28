<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Http\Request;
use QuadStudio\Service\Site\Filters\CatalogEnabledFilter;
use QuadStudio\Service\Site\Http\Requests\CatalogRequest;
use QuadStudio\Service\Site\Models\Catalog;
use QuadStudio\Service\Site\Repositories\CatalogRepository;
use QuadStudio\Service\Site\Repositories\ImageRepository;

trait CatalogControllerTrait
{

    protected $catalogs;
    protected $images;

    /**
     * Create a new controller instance.
     *
     * @param CatalogRepository $catalogs
     * @param ImageRepository $images
     */
    public function __construct(CatalogRepository $catalogs, ImageRepository $images)
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

        return view('site::admin.catalog.index', [
            'repository' => $this->catalogs,
            'catalogs'   => $this->catalogs->paginate(config('site.per_page.catalog', 10), [env('DB_PREFIX', '') . 'catalogs.*'])
        ]);
    }


    public function tree()
    {
        $tree = $this->catalogs->tree();

        return view('site::admin.catalog.tree', compact('tree'));
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
        $parent_catalog_id = !is_null($catalog) ? $catalog->id : null;
        $tree = $this->catalogs->tree();

        return view('site::admin.catalog.create', compact('parent_catalog_id', 'tree'));
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
            ['enabled' => $request->filled('enabled') ? 1 : 0]
        ));
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

        return view('site::admin.catalog.edit', compact('tree', 'catalog', 'parent_catalog_id'));
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
            ['enabled' => $request->filled('enabled') ? 1 : 0]
        ), $catalog->id);
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
        return view('site::admin.catalog.show', ['catalog' => $catalog]);
    }

    /**
     * @param Request $request
     */
    public function sort(Request $request)
    {
        Catalog::sort($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Catalog $catalog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catalog $catalog)
    {

        $this->authorize('delete', $catalog);

        if ($this->catalogs->delete($catalog->id) > 0) {
            $redirect = route('admin.catalogs.index');
        } else {
            $redirect = route('admin.catalogs.show', $catalog);
        }
        $json['redirect'] = $redirect;

        return response()->json($json);

    }
}