<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Filters\Product\TypeAdminFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\ProductAnalogRequest;
use QuadStudio\Service\Site\Http\Requests\Admin\ProductRelationRequest;
use QuadStudio\Service\Site\Http\Requests\Admin\ProductRequest;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Repositories\EquipmentRepository;
use QuadStudio\Service\Site\Repositories\ProductRepository;
use QuadStudio\Service\Site\Traits\Support\ImageLoaderTrait;

trait ProductControllerTrait
{
    use ImageLoaderTrait;
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

    public function images(ProductRequest $request, Product $product)
    {
        if ($request->isMethod('post')) {
            $this->setImages($request, $product);

            return redirect()->route('admin.products.show', $product)->with('success', trans('site::image.updated'));
        } else {
            $images = $this->getImages($request, $product);

            return view('site::admin.product.images', compact('product', 'images'));
        }
    }

    /**
     * @param ProductAnalogRequest $request
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function analogs(ProductAnalogRequest $request, Product $product)
    {
        if ($request->isMethod('post')) {
            $sku = collect(preg_split(
                "/[{$request->input('separator_row')}]+/",
                $request->input('analogs'),
                null,
                PREG_SPLIT_NO_EMPTY
            ));
            if (!empty($sku)) {
                $sku = $sku->filter(function ($value, $key) {
                    return strpos($value, " ") === false && mb_strlen($value, 'UTF-8') > 0;
                });
                $analogs = Product::whereIn('sku', $sku->toArray())->get();
                foreach ($analogs as $analog) {
                    if (!$product->analogs->contains($analog->id)) {
                        $product->attachAnalog($analog);
                    }
                    if (
                        $request->has('mirror')
                        && $request->input('mirror') == 1
                        && !$analog->analogs->contains($product->id)
                    ) {
                        $analog->attachAnalog($product);
                    }
                }
            }
            if ($request->input('_stay') == 1) {
                $redirect = redirect()->route('admin.products.analogs', $product)->with('success', trans('site::analog.updated'));
            } else {
                $redirect = redirect()->route('admin.products.show', $product)->with('success', trans('site::analog.updated'));
            }

            return $redirect;
        } else {
            $analogs = $product->analogs()->orderBy('name')->get();

            return view('site::admin.product.analogs', compact('product', 'analogs'));
        }
    }

    /**
     * @param ProductRelationRequest $request
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function relations(ProductRelationRequest $request, Product $product)
    {
        if ($request->isMethod('post')) {
            $sku = collect(preg_split(
                "/[{$request->input('separator_row')}]+/",
                $request->input('relations'),
                null,
                PREG_SPLIT_NO_EMPTY
            ));
            if (!empty($sku)) {
                $sku = $sku->filter(function ($value, $key) {
                    return strpos($value, " ") === false && mb_strlen($value, 'UTF-8') > 0;
                });
                $relations = Product::whereIn('sku', $sku->toArray())->get();
                foreach ($relations as $relation) {
                    if (!$product->relations->contains($relation->id)) {
                        $product->attachRelation($relation);
                    }
                }
            }

            if ($request->input('_stay') == 1) {
                $redirect = redirect()->route('admin.products.relations', $product)->with('success', trans('site::relation.updated'));
            } else {
                $redirect = redirect()->route('admin.products.show', $product)->with('success', trans('site::relation.updated'));
            }

            return $redirect;
        } else {
            $relations = $product->relations()->orderBy('name')->get();

            return view('site::admin.product.relations', compact('product', 'relations'));
        }
    }

    /**
     * @param ProductRelationRequest $request
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function back_relations(ProductRelationRequest $request, Product $product)
    {
        if ($request->isMethod('post')) {
            $sku = collect(preg_split(
                "/[{$request->input('separator_row')}]+/",
                $request->input('relations'),
                null,
                PREG_SPLIT_NO_EMPTY
            ));
            if (!empty($sku)) {
                $sku = $sku->filter(function ($value, $key) {
                    return strpos($value, " ") === false && mb_strlen($value, 'UTF-8') > 0;
                });
                $relations = Product::whereIn('sku', $sku->toArray())->get();
                foreach ($relations as $relation) {
                    if (!$product->back_relations->contains($relation->id)) {
                        $product->attachBackRelation($relation);
                    }
                }
            }

            if ($request->input('_stay') == 1) {
                $redirect = redirect()->route('admin.products.back_relations', $product)->with('success', trans('site::relation.updated'));
            } else {
                $redirect = redirect()->route('admin.products.show', $product)->with('success', trans('site::relation.updated'));
            }

            return $redirect;
        } else {
            $relations = $product->back_relations()->orderBy('name')->get();

            return view('site::admin.product.back_relations', compact('product', 'relations'));
        }
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