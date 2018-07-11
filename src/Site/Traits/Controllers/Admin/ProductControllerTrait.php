<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Repositories\ProductRepository as Repository;

trait ProductControllerTrait
{

    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->repository->trackFilter();

        return view('admin.product.index', [
            'repository' => $this->repository,
            'items'      => $this->repository->paginate(config('site.per_page.product', 8))
        ]);
    }

    /**
     * Show the product page
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.product.show', ['product' => $product]);
    }

}