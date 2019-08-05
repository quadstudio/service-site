<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Filters\Storehouse\StorehousePerPageFilter;
use QuadStudio\Service\Site\Filters\StorehouseProduct\StorehouseFilter;
use QuadStudio\Service\Site\Http\Requests\StorehouseRequest;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\Storehouse;
use QuadStudio\Service\Site\Repositories\StorehouseProductRepository;
use QuadStudio\Service\Site\Repositories\StorehouseRepository;

class StorehouseController extends Controller
{

    use AuthorizesRequests;

    /**
     * @var StorehouseRepository
     */
    private $storehouses;
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
        abort(404);
        $this->storehouses = $storehouses;
        $this->products = $products;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->storehouses->trackFilter();
        $this->storehouses->applyFilter(new BelongsUserFilter());
        $this->storehouses->pushTrackFilter(StorehousePerPageFilter::class);
        return view('site::storehouse.index', [
            'repository'  => $this->storehouses,
            'storehouses' => $this->storehouses->paginate(
                $request->input('filter.per_page', config('site.per_page.storehouse', 10)),
                ['storehouses.*']
            ),
        ]);
    }

    /**
     * @param Request $request
     * @param Storehouse $storehouse
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Storehouse $storehouse)
    {
        $this->authorize('view', $storehouse);

        $this->products->trackFilter();
        $repository = $this->products->applyFilter((new StorehouseFilter())->setStorehouseId($storehouse->getKey()));

        $products = $repository->paginate(
            $request->input('filter.per_page', config('site.per_page.storehouse_product', 10)),
            ['storehouse_products.*']
        );
        return view('site::storehouse.show', compact('storehouse', 'products', 'repository'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $this->authorize('create', Storehouse::class);
        $addresses = auth()->user()->addresses()->where('type_id', 6)->get();

        return view('site::storehouse.create', compact('addresses'));
    }

    /**
     * @param  StorehouseRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorehouseRequest $request)
    {
        $storehouse = $request->user()->storehouses()->create(array_merge(
            $request->input('storehouse'),
            [
                'enabled'  => $request->filled('storehouse.enabled'),
                'everyday' => $request->filled('storehouse.everyday'),
            ]
        ));

        $storehouse->attachAddresses($request);

        return redirect()->route('storehouses.show', $storehouse)->with('success', trans('site::storehouse.created'));
    }

    /**
     * @param Storehouse $storehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(Storehouse $storehouse)
    {
        $this->authorize('edit', $storehouse);
        $addresses = auth()->user()->addresses()->where('type_id', 6)->get();
        return view('site::storehouse.edit', compact('storehouse', 'addresses'));
    }

    /**
     * @param  StorehouseRequest $request
     * @param Storehouse $storehouse
     * @return \Illuminate\Http\Response
     */
    public function update(StorehouseRequest $request, Storehouse $storehouse)
    {
        $storehouse->update(array_merge(
            $request->input('storehouse'),
            [
                'enabled'  => $request->filled('storehouse.enabled'),
                'everyday' => $request->filled('storehouse.everyday'),
            ]
        ));

        $storehouse->attachAddresses($request);

        return redirect()->route('storehouses.show', $storehouse)->with('success', trans('site::storehouse.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Storehouse $storehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Storehouse $storehouse)
    {

        $this->authorize('delete', $storehouse);

        if ($storehouse->delete()) {
            Session::flash('success', trans('site::storehouse.deleted'));
            $redirect = route('storehouses.index');
        } else {
            Session::flash('error', trans('site::storehouse.error.deleted'));
            $redirect = route('storehouses.show', $storehouse);
        }
        $json['redirect'] = $redirect;

        return response()->json($json);

    }

}