<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\Equipment\HasProductFilter;
use QuadStudio\Service\Site\Filters\Equipment\SortFilter;
use QuadStudio\Service\Site\Filters\Equipment\EquipmentShowFilter;
use QuadStudio\Service\Site\Filters\Product\BoilerFilter;
use QuadStudio\Service\Site\Filters\Product\EquipmentFilter;
use QuadStudio\Service\Site\Filters\Product\HasNameFilter;
use QuadStudio\Service\Site\Filters\Product\ProductShowFilter;
use QuadStudio\Service\Site\Filters\Product\TypeFilter;
use QuadStudio\Service\Site\Filters\ProductCanBuyFilter;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Models\Scheme;
use QuadStudio\Service\Site\Repositories\EquipmentRepository;
use QuadStudio\Service\Site\Repositories\ProductRepository;

class ProductController extends Controller
{

    use AuthorizesRequests;
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
        $this->products->applyFilter(new ProductCanBuyFilter());
        $this->products->applyFilter(new ProductShowFilter());
        $this->products->applyFilter(new HasNameFilter());
        $this->products->pushTrackFilter(TypeFilter::class);
        $this->products->pushTrackFilter(EquipmentFilter::class);
        $this->products->pushTrackFilter(BoilerFilter::class);
        
        return view('site::product.index', [
            'repository' => $this->products,
            'products'   => $this->products->paginate(config('site.per_page.product', 20)),
        ]);
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $this->authorize('list', Product::class);
        $this->products->trackFilter();
        $this->products->applyFilter(new ProductCanBuyFilter());
        $this->products->applyFilter(new HasNameFilter());
        $this->products->pushTrackFilter(TypeFilter::class);
        $this->products->pushTrackFilter(EquipmentFilter::class);
        
        return view('site::product.list', [
            'repository' => $this->products,
            'products'   => $this->products->paginate(config('site.per_page.product_list', 50)),
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

        if ($product->getAttribute(config('site.check_field')) === false || $product->getAttribute('enabled') === false) {
            abort(404);
        }
        $equipments = $this
            ->equipments
            ->applyFilter(new SortFilter())
            ->applyFilter(new EquipmentShowFilter())
            ->applyFilter((new HasProductFilter())->setProduct($product))
            ->all();
        $analogs = $product->analogs()->where('enabled', 1)->where(config('site.check_field'), 1)->orderBy('name')->get();
        $back_relations = $product->relations()->where('enabled', 1)->where(config('site.check_field'), 1)->orderBy('name')->get();
        $details = $product->details()->where('enabled', 1)->where(config('site.check_field'), 1)->orderBy('name')->get();
        $images = $product->images()->get();
        $schemes = $product->schemes()->get();
        $datasheets = $product->datasheets()->with('schemes')->get();

        $storehouse_addresses = $product->storehouseAddresses();

        return view('site::product.show', compact(
            'product',
            'equipments',
            'back_relations',
            'analogs',
            //'relations',
            'storehouse_addresses',
            'details',
            'images',
            'schemes',
            'datasheets'
        ));
    }

    public function scheme(Product $product, Scheme $scheme)
    {
        $datasheets = $product->datasheets()
            ->has('schemes')
            ->with('schemes')
            ->get();
        $url = ['name' => $product->getAttribute('name')];
        if ($product->canBuy) {
            $url['url'] = route('products.show', $product);
        }
        $elements = $scheme->elements()
            ->with('product')
            ->with('pointers')
            ->with('shapes')
            ->orderBy('sort_order')
            ->get();

        return view('site::product.scheme', compact(
            'product',
            'datasheets',
            'scheme',
            'elements',
            'url'
        ));
    }

}