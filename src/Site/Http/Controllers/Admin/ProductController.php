<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\Product\ProductBoolActiveFilter;
use QuadStudio\Service\Site\Filters\Product\ProductBoolEnabledFilter;
use QuadStudio\Service\Site\Filters\Product\ProductBoolForSaleFilter;
use QuadStudio\Service\Site\Filters\Product\ProductBoolServiceFilter;
use QuadStudio\Service\Site\Filters\Product\ProductBoolWarrantyFilter;
use QuadStudio\Service\Site\Filters\Product\ProductHasAnalogsFilter;
use QuadStudio\Service\Site\Filters\Product\ProductHasImagesFilter;
use QuadStudio\Service\Site\Filters\Product\ProductHasMountingBonusFilter;
use QuadStudio\Service\Site\Filters\Product\ProductHasPricesFilter;
use QuadStudio\Service\Site\Filters\Product\ProductHasQuantityFilter;
use QuadStudio\Service\Site\Filters\Product\ProductHasRelationsFilter;
use QuadStudio\Service\Site\Filters\Product\ProductPerPage10Filter;
use QuadStudio\Service\Site\Filters\Product\ProductShowFerroliBoolFilter;
use QuadStudio\Service\Site\Filters\Product\ProductShowLamborghiniBoolFilter;
use QuadStudio\Service\Site\Filters\Product\TypeAdminFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\ProductRequest;
use QuadStudio\Service\Site\Models\Equipment;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Models\ProductType;
use QuadStudio\Service\Site\Repositories\ProductRepository;

class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    protected $products;

    /**
     * Create a new controller instance.
     *
     * @param ProductRepository $products
     */
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    /**
     * Show the shop index page
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(ProductRequest $request)
    {

        $this->products->trackFilter();
        $this->products->pushTrackFilter(TypeAdminFilter::class);
        $this->products->pushTrackFilter(ProductHasMountingBonusFilter::class);
        $this->products->pushTrackFilter(ProductHasPricesFilter::class);
        $this->products->pushTrackFilter(ProductHasQuantityFilter::class);
        $this->products->pushTrackFilter(ProductHasImagesFilter::class);
        $this->products->pushTrackFilter(ProductHasAnalogsFilter::class);
        $this->products->pushTrackFilter(ProductHasRelationsFilter::class);
        $this->products->pushTrackFilter(ProductBoolEnabledFilter::class);
        $this->products->pushTrackFilter(ProductShowFerroliBoolFilter::class);
        $this->products->pushTrackFilter(ProductShowLamborghiniBoolFilter::class);
        $this->products->pushTrackFilter(ProductBoolForSaleFilter::class);
        $this->products->pushTrackFilter(ProductBoolWarrantyFilter::class);
        $this->products->pushTrackFilter(ProductBoolServiceFilter::class);
        $this->products->pushTrackFilter(ProductPerPage10Filter::class);

        return view('site::admin.product.index', [
            'repository' => $this->products,
            'products'   => $this->products->paginate($request->input('filter.per_page', config('site.per_page.product_admin', 10)), ['products.*'])
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
        $prices = $product->prices()->typeEnabled()->get();

        return view('site::admin.product.show', compact('product', 'prices'));
    }

    public function edit(Product $product)
    {
        $equipments = Equipment::query()->orderBy('name')->get();
        $product_types = ProductType::query()->get();

        return view('site::admin.product.edit', compact('product', 'equipments', 'product_types'));
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

        $product->update(array_merge(
            $request->input(['product']),
            [
                'show_ferroli'     => $request->filled('product.show_ferroli'),
                'show_lamborghini' => $request->filled('product.show_lamborghini')
            ]
        ));

        return redirect()->route('admin.products.show', $product)->with('success', trans('site::product.updated'));
    }

}