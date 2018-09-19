<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Filters\Datasheet\TypeFilter;
use QuadStudio\Service\Site\Filters\Equipment\HasProductsFilter;
use QuadStudio\Service\Site\Filters\Equipment\SortByNameFilter;
use QuadStudio\Service\Site\Filters\Equipment\WithProductsFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\SchemeRequest;
use QuadStudio\Service\Site\Http\Requests\ImageRequest;
use QuadStudio\Service\Site\Jobs\ProcessSchemeImage;
use QuadStudio\Service\Site\Models\Image;
use QuadStudio\Service\Site\Models\Scheme;
use QuadStudio\Service\Site\Repositories\BlockRepository;
use QuadStudio\Service\Site\Repositories\DatasheetRepository;
use QuadStudio\Service\Site\Repositories\EquipmentRepository;
use QuadStudio\Service\Site\Repositories\SchemeRepository;
use Illuminate\Http\File;

trait SchemeControllerTrait
{
    /**
     * @var SchemeRepository
     */
    private $schemes;
    /**
     * @var BlockRepository
     */
    private $blocks;
    /**
     * @var DatasheetRepository
     */
    private $datasheets;
    /**
     * @var EquipmentRepository
     */
    private $equipments;

    /**
     * Create a new controller instance.
     *
     * @param SchemeRepository $schemes
     * @param BlockRepository $blocks
     * @param DatasheetRepository $datasheets
     * @param EquipmentRepository $equipments
     */
    public function __construct(
        SchemeRepository $schemes,
        BlockRepository $blocks,
        DatasheetRepository $datasheets,
        EquipmentRepository $equipments
    )
    {
        $this->schemes = $schemes;
        $this->blocks = $blocks;
        $this->datasheets = $datasheets;
        $this->equipments = $equipments;
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->schemes->trackFilter();

        return view('site::admin.scheme.index', [
            'repository' => $this->schemes,
            'schemes'    => $this->schemes->paginate(config('site.per_page.scheme', 10), ['schemes.*'])
        ]);
    }

    public function create()
    {
        $blocks = $this->blocks->trackFilter()->all();
        $datasheets = $this->datasheets
            ->trackFilter()
            ->applyFilter((new TypeFilter())->setTypeId(4))
            ->all();

        return view('site::admin.scheme.create', compact('blocks', 'datasheets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ImageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function image(ImageRequest $request)
    {

        $this->authorize('create', Image::class);
        $file = $request->file('path');

        $image = new Image([
            'path' => Storage::disk($request->input('storage'))->putFile('', new File($file->getPathName())),
            'mime' => $file->getMimeType(),
            'storage' => $request->input('storage'),
            'size' => $file->getSize(),
            'name' => $file->getClientOriginalName(),
        ]);

        $image->save();

        ProcessSchemeImage::dispatch($image, $request->input('storage'))->onQueue('images');

        return response()->json([
            'update' => [
                '#image-src' => view('site::admin.scheme.image', ['image'   => $image])->render()
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SchemeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchemeRequest $request)
    {

        //dd($request->all());
        $scheme = $this->schemes->create($request->except(['_token', '_method', '_create']));
        $scheme->attachProducts($request->input('products', []));
        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('admin.schemes.create')->with('success', trans('site::scheme.created'));
        } else {
            $redirect = redirect()->route('admin.schemes.index')->with('success', trans('site::scheme.created'));
        }

        return $redirect;
    }


    /**
     * @param Scheme $scheme
     * @return \Illuminate\Http\Response
     */
    public function edit(Scheme $scheme)
    {
        return view('site::admin.scheme.edit', compact('scheme'));
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

        $scheme->update($request->except(['_method', '_token', '_stay']));

        if ($request->input('_stay') == 1) {

            $redirect = redirect()->route('admin.schemes.edit', $scheme)->with('success', trans('site::scheme.updated'));
        } else {
            $redirect = redirect()->route('admin.schemes.index')->with('success', trans('site::scheme.updated'));
        }

        return $redirect;
    }

    public function sort(Request $request)
    {
        $sort = array_flip($request->input('sort'));

        foreach ($sort as $scheme_id => $sort_order) {
            /** @var Scheme $scheme */
            $scheme = Scheme::find($scheme_id);
            $scheme->setAttribute('sort_order', $sort_order);
            $scheme->save();
        }
    }


}