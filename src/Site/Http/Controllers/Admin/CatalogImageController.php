<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\CatalogEnabledFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\CatalogRequest;
use QuadStudio\Service\Site\Models\Catalog;
use QuadStudio\Service\Site\Repositories\CatalogRepository;
use QuadStudio\Service\Site\Repositories\ImageRepository;

class CatalogImageController extends Controller
{

    use AuthorizesRequests;
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
            'catalogs'   => $this->catalogs->paginate(config('site.per_page.catalog', 10), ['catalogs.*'])
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
     * @param Catalog|null $catalog
     * @return \Illuminate\Http\Response
     */
    public function create(Catalog $catalog = null)
    {
        $this->authorize('create', Catalog::class);
        $parent_catalog_id = !is_null($catalog) ? $catalog->getAttribute('id') : null;
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

        $catalog = $this->catalogs->create(array_merge(
            $request->except(['_token', '_method', '_create', 'image']),
            ['enabled' => $request->filled('enabled') ? 1 : 0]
        ));

        return redirect()->route('admin.catalogs.show', $catalog)->with('success', trans('site::catalog.created'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Catalog $catalog
     * @return \Illuminate\Http\Response
     */
    public function edit(Catalog $catalog)
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
        $catalog->update(array_merge(
            $request->only(['name', 'name_plural', 'description', 'catalog_id']),
            ['enabled' => $request->filled('enabled') ? 1 : 0]
        ));

        return redirect()->route('admin.catalogs.show', $catalog)->with('success', trans('site::catalog.updated'));
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

        if ($this->catalogs->delete($catalog->getAttribute('id')) > 0) {
            $redirect = route('admin.catalogs.index');
        } else {
            $redirect = route('admin.catalogs.show', $catalog);
        }
        $json['redirect'] = $redirect;

        return response()->json($json);

    }
}