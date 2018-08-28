<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Filters\Product\TypeAdminFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\ProductRequest;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Repositories\EquipmentRepository;
use QuadStudio\Service\Site\Repositories\ProductRepository;

trait ProductControllerTrait
{
    /**
     * @var ProductRepository
     */
    protected $products;
    /**
     * @var EquipmentRepository
     */
    private $equipments;

    /**
     * Create a new controller instance.
     *
     * @param ProductRepository $products
     * @param EquipmentRepository $equipments
     */
    public function __construct(ProductRepository $products, EquipmentRepository $equipments)
    {
        $this->products = $products;
        $this->equipments = $equipments;
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->products->trackFilter();
        $this->products->pushTrackFilter(TypeAdminFilter::class);

        return view('site::admin.product.index', [
            'repository' => $this->products,
            'products'   => $this->products->paginate(config('site.per_page.product', 12), [env('DB_PREFIX', '') . 'products.*'])
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
        return view('site::admin.product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $equipments = $this->equipments->all();

        return view('site::admin.product.edit', compact('product', 'equipments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductRequest $request
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        $this->products->update($request->except(['_method', '_token', '_stay']), $product->id);

        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('admin.products.edit', $product)->with('success', trans('site::product.updated'));
        } else {
            $redirect = redirect()->route('admin.products.show', $product)->with('success', trans('site::product.updated'));
        }

        return $redirect;
    }

}