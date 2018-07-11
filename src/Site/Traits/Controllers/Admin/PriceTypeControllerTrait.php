<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Repositories\PriceTypeRepository;

trait PriceTypeControllerTrait
{

    protected $types;

    /**
     * Create a new controller instance.
     *
     * @param PriceTypeRepository $types
     */
    public function __construct(PriceTypeRepository $types)
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

        return view('admin.price-type.index', [
            'repository' => $this->types,
            'types'      => $this->types->paginate(config('site.per_page.price_type', 20))
        ]);
    }

}