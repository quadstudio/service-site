<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Concerns\StoreFiles;
use QuadStudio\Service\Site\Filters\Datasheet\DatasheetPerPageFilter;
use QuadStudio\Service\Site\Filters\Datasheet\DatasheetShowFerroliBoolFilter;
use QuadStudio\Service\Site\Filters\Datasheet\DatasheetShowLamborghiniBoolFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\DatasheetProductRequest;
use QuadStudio\Service\Site\Http\Requests\Admin\DatasheetRequest;
use QuadStudio\Service\Site\Http\Requests\FileRequest;
use QuadStudio\Service\Site\Models\Datasheet;
use QuadStudio\Service\Site\Models\FileType;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Repositories\DatasheetRepository;


class DatasheetController extends Controller
{

    use AuthorizesRequests, StoreFiles;

    protected $datasheets;

    /**
     * Create a new controller instance.
     *
     * @param DatasheetRepository $datasheets
     */
    public function __construct(DatasheetRepository $datasheets)
    {
        $this->datasheets = $datasheets;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->datasheets
            ->trackFilter()
            ->pushTrackFilter(DatasheetShowFerroliBoolFilter::class)
            ->pushTrackFilter(DatasheetShowLamborghiniBoolFilter::class)
            ->pushTrackFilter(DatasheetPerPageFilter::class);

        return view('site::admin.datasheet.index', [
            'repository' => $this->datasheets,
            'datasheets' => $this->datasheets->paginate($request->input('filter.per_page', config('site.per_page.datasheet', 10)), ['datasheets.*'])
        ]);
    }

    public function show(Datasheet $datasheet)
    {
        $datasheet->with('products.type')->with('schemes');

        return view('site::admin.datasheet.show', compact('datasheet'));
    }

    public function create(FileRequest $request)
    {
        $this->authorize('create', Datasheet::class);
        $file_types = FileType::query()->where('group_id', 2)->orderBy('sort_order')->get();
        $file = $this->getFile($request);

        return view('site::admin.datasheet.create', compact('file_types', 'file'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DatasheetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DatasheetRequest $request)
    {

        $datasheet = $this->datasheets->create(array_merge(
            $request->input(['datasheet']),
            [
                'active'           => $request->filled('datasheet.active'),
                'show_ferroli'     => $request->filled('datasheet.show_ferroli'),
                'show_lamborghini' => $request->filled('datasheet.show_lamborghini')
            ]
        ));
        /** @var Datasheet $datasheet */
        $datasheet->file()->update(['type_id' => $request->input('datasheet.type_id')]);

        return redirect()->route('admin.datasheets.show', $datasheet)->with('success', trans('site::datasheet.created'));
    }

    public function edit(FileRequest $request, Datasheet $datasheet)
    {

        $types = FileType::query()->where('group_id', 2)->orderBy('sort_order')->get();
        $file = $this->getFile($request, $datasheet);

        return view('site::admin.datasheet.edit', compact('datasheet', 'types', 'file'));
    }

    public function update(DatasheetRequest $request, Datasheet $datasheet)
    {

        $datasheet->update(array_merge(
            $request->input(['datasheet']),
            [
                'active'           => $request->filled('datasheet.active'),
                'show_ferroli'     => $request->filled('datasheet.show_ferroli'),
                'show_lamborghini' => $request->filled('datasheet.show_lamborghini')
            ]
        ));
        $datasheet->file
            ->setAttribute('type_id', $request->input('datasheet.type_id'))
            ->setAttribute('size', filesize(Storage::disk($datasheet->file->storage)->getAdapter()->getPathPrefix() . $datasheet->file->path))
            ->save();

        return redirect()->route('admin.datasheets.show', $datasheet)->with('success', trans('site::datasheet.updated'));
    }


    /**
     * @param DatasheetProductRequest $request
     * @param Datasheet $datasheet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function products(DatasheetProductRequest $request, Datasheet $datasheet)
    {
        if ($request->isMethod('post')) {
            $sku = collect(preg_split(
                "/[{$request->input('separator_row')}]+/",
                $request->input('products'),
                null,
                PREG_SPLIT_NO_EMPTY
            ));
            if (!empty($sku)) {
                $sku = $sku->filter(function ($value, $key) {
                    return strpos($value, " ") === false && mb_strlen($value, 'UTF-8') > 0;
                });
                $products = Product::query()->whereIn('sku', $sku->toArray())->get();
                foreach ($products as $product) {
                    if (!$datasheet->products->contains($product->id)) {
                        $datasheet->products()->attach($product);
                    }
                }
            }

            return redirect()->route('admin.datasheets.products', $datasheet)->with('success', trans('site::datasheet.updated_products'));
        } elseif ($request->isMethod('delete')) {
            $datasheet->products()->detach($request->input('delete'));

            return redirect()->route('admin.datasheets.products', $datasheet)->with('success', trans('site::datasheet.deleted_products'));
        } else {
            $products = $datasheet->products()->orderBy('name')->get();

            return view('site::admin.datasheet.products', compact('datasheet', 'products'));
        }
    }

}