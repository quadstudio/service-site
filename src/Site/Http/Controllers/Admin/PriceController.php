<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Models\Price;
use QuadStudio\Service\Site\Repositories\PriceRepository as Repository;

class PriceController extends Controller
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

        return view('admin.price.index', [
            'repository' => $this->repository,
            'items'      => $this->repository->paginate(config('site.per_page.price', 8))
        ]);
    }

    /**
     * Show the price page
     *
     * @param Price $price
     * @return \Illuminate\Http\Response
     */
    public function show(Price $price)
    {
        return view('admin.price.show', ['price' => $price]);
    }

}