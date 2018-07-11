<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;

use QuadStudio\Service\Site\Http\Resources\CatalogCollection;
use QuadStudio\Service\Site\Http\Resources\CatalogResource;
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
     * @return CatalogCollection
     */
    public function index()
    {
        return new CatalogCollection($this->catalogs->paginate(config('site.per_page.catalog', 10)));
    }

    /**
     * @param Catalog $catalog
     * @return CatalogResource
     */
    public function show(Catalog $catalog)
    {
        $this->authorize('view', $catalog);
        return new CatalogResource($catalog);
    }

}