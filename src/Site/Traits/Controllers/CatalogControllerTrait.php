<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\CatalogRootFilter;
use QuadStudio\Service\Site\Filters\EnabledFilter;
use QuadStudio\Service\Site\Models\Catalog;
use QuadStudio\Service\Site\Repositories\CatalogRepository;

trait CatalogControllerTrait
{
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
        $this->catalogs->trackFilter();
        $this->catalogs->applyFilter(new CatalogRootFilter());
        $this->catalogs->applyFilter(new EnabledFilter());

        return view('site::catalog.index', [
            'catalogs' => $this->catalogs->all([env('DB_PREFIX', '') . 'catalogs.*'])
        ]);
    }

    public function show(Catalog $catalog)
    {
        if($catalog->enabled == 0){
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