<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Concerns\StoreImages;
use QuadStudio\Service\Site\Filters\Scheme\BlockSelectFilter;
use QuadStudio\Service\Site\Filters\Scheme\DatasheetSelectFilter;
use QuadStudio\Service\Site\Filters\Scheme\ProductSelectFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\DatasheetRequest;
use QuadStudio\Service\Site\Http\Requests\Admin\SchemeElementRequest;
use QuadStudio\Service\Site\Http\Requests\Admin\SchemeRequest;
use QuadStudio\Service\Site\Models\Block;
use QuadStudio\Service\Site\Models\Datasheet;
use QuadStudio\Service\Site\Models\Element;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Models\Scheme;
use QuadStudio\Service\Site\Repositories\SchemeRepository;

class SchemeController extends Controller
{
    use AuthorizesRequests, StoreImages;
    /**
     * @var SchemeRepository
     */
    private $schemes;

    /**
     * Create a new controller instance.
     *
     * @param SchemeRepository $schemes
     */
    public function __construct(SchemeRepository $schemes)
    {
        $this->schemes = $schemes;
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->schemes->trackFilter();
        $this->schemes->pushTrackFilter(ProductSelectFilter::class);
        $this->schemes->pushTrackFilter(BlockSelectFilter::class);
        $this->schemes->pushTrackFilter(DatasheetSelectFilter::class);

        return view('site::admin.scheme.index', [
            'repository' => $this->schemes,
            'schemes'    => $this->schemes->paginate(config('site.per_page.scheme', 10), ['schemes.*'])
        ]);
    }

    /**
     * @param DatasheetRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(DatasheetRequest $request)
    {
        $blocks = Block::query()->orderBy('name')->get();
        $datasheets = Datasheet::query()->with('file')->whereHas('file', function ($file) {
            $file->where('files.type_id', 4);
        })
            ->whereNotNull('name')
            ->orderBy('name')
            ->get();
        $image = $this->getImage($request);

        return view('site::admin.scheme.create', compact('blocks', 'datasheets', 'image'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SchemeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchemeRequest $request)
    {

        $scheme = $this->schemes->create($request->input('scheme'));

        return redirect()->route('admin.schemes.show', $scheme)->with('success', trans('site::scheme.created'));
    }


    /**
     * @param SchemeRequest $request
     * @param Scheme $scheme
     * @return \Illuminate\Http\Response
     */
    public function edit(SchemeRequest $request, Scheme $scheme)
    {
        $blocks = Block::query()->orderBy('name')->get();
        $datasheets = Datasheet::query()->with('file')->whereHas('file', function ($file) {
            $file->where('files.type_id', 4);
        })
            ->whereNotNull('name')
            ->orderBy('name')
            ->get();
        $image = $this->getImage($request, $scheme);

        return view('site::admin.scheme.edit', compact('scheme', 'blocks', 'datasheets', 'image'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  SchemeRequest $request
     * @param  Scheme $scheme
     * @return \Illuminate\Http\Response
     */
    public function update(SchemeRequest $request, Scheme $scheme)
    {

        $scheme->update($request->input('scheme'));

        return redirect()->route('admin.schemes.show', $scheme)->with('success', trans('site::scheme.updated'));
    }

    /**
     * Display the specified resource.
     *
     * @param Scheme $scheme
     * @return \Illuminate\Http\Response
     */
    public function show(Scheme $scheme)
    {
        $scheme
            ->with('products')
            ->with('elements.shapes')
            ->with('elements.pointers')
            ->with('block');
        $elements = $scheme->elements()->orderBy('sort_order')->get();

        return view('site::admin.scheme.show', compact('scheme', 'elements'));
    }

    /**
     * Display the specified resource.
     *
     * @param Scheme $scheme
     * @return \Illuminate\Http\Response
     */
    public function pointers(Scheme $scheme)
    {
        $scheme
            ->with('products')
            ->with('elements.pointers')
            ->with('block');
        $elements = $scheme->elements()->orderBy('sort_order')->get();

        return view('site::admin.scheme.pointers', compact('scheme', 'elements'));
    }

    /**
     * Display the specified resource.
     *
     * @param Scheme $scheme
     * @return \Illuminate\Http\Response
     */
    public function shapes(Scheme $scheme)
    {
        $scheme
            ->with('products')
            ->with('elements.shapes')
            ->with('block');
        $elements = $scheme->elements()->orderBy('sort_order')->get();

        return view('site::admin.scheme.shapes', compact('scheme', 'elements'));
    }

    public function sort(Request $request)
    {
        $sort = array_flip($request->input('sort'));

        foreach ($sort as $scheme_id => $sort_order) {
            /** @var Scheme $scheme */
            $scheme = Scheme::query()->find($scheme_id);
            $scheme->setAttribute('sort_order', $sort_order);
            $scheme->save();
        }
    }

    /**
     * @param SchemeElementRequest $request
     * @param Scheme $scheme
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function elements(SchemeElementRequest $request, Scheme $scheme)
    {
        if ($request->isMethod('delete')) {
            Element::query()->whereIn('id', $request->input('elements'))->delete();

            return redirect()->route('admin.schemes.elements', $scheme)->with('success', trans('site::element.deleted'));
        } elseif ($request->isMethod('post')) {


            // Делим данные на строки
            $rows = collect(preg_split(
                "/[{$request->input('separator_row')}]+/",
                $request->input('elements'),
                null,
                PREG_SPLIT_NO_EMPTY

            // Удаляем строки в которых нет данных или нет разделителя
            ))->filter(function ($row) use ($request) {
                return mb_strlen(trim($row), 'UTF-8') > 0 && preg_match("/[{$request->input('separator_column')}]+/", $row) === 1;

                // разбиваем строку на столбцы
            })->transform(function ($row, $key) use ($request, $scheme) {
                //dd($row);
                $columns = preg_split(
                    "/[{$request->input('separator_column')}]+/",
                    $row,
                    null,
                    PREG_SPLIT_NO_EMPTY
                );

                return ['number' => $columns[0], 'sku' => $columns[1], 'sort_order' => $scheme->elements()->count() + $key];
            })->filter(function ($row) use ($scheme) {
                return Product::query()->where('sku', $row['sku'])->where('enabled', 1)->exists()
                    && (
                        $scheme->elements->isEmpty()
                        || $scheme->elements->every(function ($element) use ($row) {
                            return $element->product->sku != $row['sku'];
                        }));
            })->map(function ($row) {
                $row['product_id'] = Product::query()->where('sku', $row['sku'])->first()->id;

                return $row;
            });

            $scheme->elements()->createMany($rows->toArray());


            if ($request->input('_stay') == 1) {
                $redirect = redirect()->route('admin.schemes.elements', $scheme)->with('success', trans('site::element.created'));
            } else {
                $redirect = redirect()->route('admin.schemes.show', $scheme)->with('success', trans('site::element.created'));
            }

            return $redirect;
        } else {
            $elements = $scheme->elements()->orderBy('sort_order')->get();

            return view('site::admin.scheme.elements', compact('scheme', 'elements'));
        }
    }

    /**
     * @param Scheme $scheme
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Scheme $scheme)
    {

        if ($scheme->delete()) {
            return redirect()->route('admin.schemes.index')->with('success', trans('site::scheme.deleted'));
        } else {
            return redirect()->route('admin.schemes.show', $scheme)->with('error', trans('site::scheme.error.deleted'));
        }
    }

}