<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\Storehouse\StorehousePerPageFilter;
use QuadStudio\Service\Site\Filters\Storehouse\StorehouseUserFilter;
use QuadStudio\Service\Site\Filters\StorehouseProduct\StorehouseFilter;
use QuadStudio\Service\Site\Repositories\StorehouseProductRepository;
use QuadStudio\Service\Site\Repositories\StorehouseRepository;
use QuadStudio\Service\Site\Models\Storehouse;

class StorehouseController extends Controller
{
    /**
     * @var StorehouseRepository
     */
    protected $storehouses;

    /**
     * @var StorehouseProductRepository
     */
    private $products;

    /**
     * Create a new controller instance.
     *
     * @param StorehouseRepository $storehouses
     * @param StorehouseProductRepository $products
     */
    public function __construct(StorehouseRepository $storehouses, StorehouseProductRepository $products)
    {
        $this->storehouses = $storehouses;
        $this->products = $products;
    }

    /**
     * Show the user profile
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->storehouses->trackFilter();
        $this->storehouses->pushTrackFilter(StorehouseUserFilter::class);
        $this->storehouses->pushTrackFilter(StorehousePerPageFilter::class);
        return view('site::admin.storehouse.index', [
            'repository' => $this->storehouses,
            'storehouses' => $this->storehouses->paginate(
                $request->input('filter.per_page', config('site.per_page.storehouse', 10)),
                ['storehouses.*']
            )
        ]);
    }

    public function show(Request $request, Storehouse $storehouse)
    {
        $repository = $this->products->applyFilter((new StorehouseFilter())->setStorehouseId($storehouse->getKey()));

        $products = $repository->paginate(
            $request->input('filter.per_page', config('site.per_page.storehouse_product', 10)),
            ['storehouse_products.*']
        );

        return view('site::admin.storehouse.show', compact('storehouse', 'products', 'repository'));
    }
}