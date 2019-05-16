<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\Catalog\CatalogShowFilter;
use QuadStudio\Service\Site\Filters\CatalogRootFilter;
use QuadStudio\Service\Site\Filters\EnabledFilter;
use QuadStudio\Service\Site\Models\Catalog;
use QuadStudio\Service\Site\Repositories\CatalogRepository;

class CatalogController extends Controller
{

    use AuthorizesRequests;

    protected $catalogs;

    /**
     * Create a new controller instance.
     *
     * @param CatalogRepository $catalogs
     */
    public function __construct(CatalogRepository $catalogs)
    {
        $this->catalogs = $catalogs;
    }

    /**
     * Show the equipment index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->catalogs
            ->trackFilter()
            ->applyFilter(new CatalogRootFilter())
            ->applyFilter(new EnabledFilter())
            ->applyFilter(new CatalogShowFilter());

        return view('site::catalog.index', [
            'catalogs' => $this->catalogs->all(['catalogs.*'])
        ]);
    }

    public function show(Catalog $catalog)
    {
        if (
            $catalog->getAttribute(config('site.check_field')) === false
            || $catalog->getAttribute('enabled') === false
        ) {
            abort(404);
        }

        return view('site::catalog.show', compact('catalog'));
    }

    public function list(Catalog $catalog)
    {
        $this->authorize('list', Catalog::class);

        return view('site::catalog.list', compact('catalog'));
    }

}