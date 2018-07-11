<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Repositories\ProductTypeRepository;

trait ProductTypeControllerTrait
{

    protected $types;

    /**
     * Create a new controller instance.
     *
     * @param ProductTypeRepository $types
     */
    public function __construct(ProductTypeRepository $types)
    {
        $this->types = $types;
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->types->trackFilter();

        return view('admin.product-type.index', [
            'repository' => $this->types,
            'items'      => $this->types->paginate(config('site.per_page.product_type', 20))
        ]);
    }

}