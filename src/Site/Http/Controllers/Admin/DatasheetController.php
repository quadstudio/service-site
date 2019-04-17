<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Http\Requests\Admin\DatasheetProductRequest;
use QuadStudio\Service\Site\Http\Requests\Admin\DatasheetRequest;
use QuadStudio\Service\Site\Http\Requests\FileRequest;
use QuadStudio\Service\Site\Models\Datasheet;
use QuadStudio\Service\Site\Models\FileType;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Repositories\DatasheetRepository;
use QuadStudio\Service\Site\Traits\Support\SingleFileLoaderTrait;


class DatasheetController extends Controller
{

    use SingleFileLoaderTrait;

    protected $datasheets;

    /**
     * Create a new controller instance.
     *
     * @param DatasheetRepository $datasheets
     */
    public function __construct(DatasheetRepository $datasheets)
    {
        $this->datasheets = $datasheets;
        //$this->products = $products;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->datasheets->trackFilter();

        return view('site::admin.datasheet.index', [
            'repository' => $this->datasheets,
            'datasheets' => $this->datasheets->paginate(config('site.per_page.datasheet', 10), ['datasheets.*'])
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
        $types = FileType::where('group_id', 2)->orderBy('sort_order')->get();
        $file = $this->getFile($request);

        return view('site::admin.datasheet.create', compact('types', 'file'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DatasheetRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DatasheetRequest $request)
    {
        $datasheet = $this->datasheets->create($request->except(['_token', '_method', '_create', 'type_id']));
        $datasheet->file->setAttribute('type_id', $request->input('type_id'))->save();
        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('admin.datasheets.create')->with('success', trans('site::datasheet.created'));
        } else {
            $redirect = redirect()->route('admin.datasheets.show', $datasheet)->with('success', trans('site::datasheet.created'));
        }

        return $redirect;
    }

    public function update(DatasheetRequest $request, Datasheet $datasheet)
    {

        $datasheet->update($request->except(['_method', '_token', '_stay', 'type_id']));
        $datasheet->file
            ->setAttribute('type_id', $request->input('type_id'))
            ->setAttribute('size', filesize(Storage::disk($datasheet->file->storage)->getAdapter()->getPathPrefix() . $datasheet->file->path))
            ->save();
        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('admin.datasheets.edit', $datasheet)->with('success', trans('site::datasheet.updated'));
        } else {
            $redirect = redirect()->route('admin.datasheets.show', $datasheet)->with('success', trans('site::datasheet.updated'));
        }

        return $redirect;
    }

    public function edit(FileRequest $request, Datasheet $datasheet)
    {
        $this->authorize('edit', $datasheet);
        $types = FileType::where('group_id', 2)->orderBy('sort_order')->get();
        $file = $this->getFile($request, $datasheet);

        return view('site::admin.datasheet.edit', compact('datasheet', 'types', 'file'));
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
                $products = Product::whereIn('sku', $sku->toArray())->get();
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