<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Http\Requests\Admin\FileTypeRequest;
use QuadStudio\Service\Site\Models\FileGroup;
use QuadStudio\Service\Site\Models\FileType;
use QuadStudio\Service\Site\Repositories\FileGroupRepository;
use QuadStudio\Service\Site\Repositories\FileTypeRepository;

trait FileTypeControllerTrait
{

    protected $types;
    /**
     * @var FileGroupRepository
     */
    private $groups;

    /**
     * Create a new controller instance.
     *
     * @param FileTypeRepository $types
     * @param FileGroupRepository $groups
     */
    public function __construct(FileTypeRepository $types, FileGroupRepository $groups)
    {
        $this->types = $types;
        $this->groups = $groups;
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->types->trackFilter();

        return view('site::admin.file_type.index', [
            'repository' => $this->types,
            'types'      => $this->types->paginate(config('site.per_page.file_type', 25), ['file_types.*'])
        ]);
    }

    public function create()
    {
        $groups = $this->groups->all();

        return view('site::admin.file_type.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FileTypeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileTypeRequest $request)
    {

        //dd($request->all());
        $file_type = $this->types->create(array_merge(
            $request->except(['_method', '_token', '_create']),
            [
                'enabled'  => $request->filled('enabled') ? 1 : 0,
                'required' => $request->filled('required') ? 1 : 0,
                'sort_order' => FileGroup::find($request->input('group_id'))->types()->count()
            ]
        ));
        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('admin.file_types.create')->with('success', trans('site::file_type.created'));
        } else {
            $redirect = redirect()->route('admin.file_types.show', $file_type)->with('success', trans('site::file_type.created'));
        }

        return $redirect;
    }

    public function show(FileType $file_type)
    {
        return view('site::admin.file_type.show', compact('file_type'));
    }

    public function edit(FileType $file_type)
    {
        $groups = $this->groups->all();

        return view('site::admin.file_type.edit', compact('file_type', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FileTypeRequest $request
     * @param  FileType $file_type
     * @return \Illuminate\Http\Response
     */
    public function update(FileTypeRequest $request, FileType $file_type)
    {
        $file_type->update(array_merge(
            $request->except(['_method', '_token', '_stay']),
            [
                'enabled'  => $request->filled('enabled') ? 1 : 0,
                'required' => $request->filled('required') ? 1 : 0
            ]
        ));
        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('admin.file_types.edit', $file_type)->with('success', trans('site::file_type.updated'));
        } else {
            $redirect = redirect()->route('admin.file_types.show', $file_type)->with('success', trans('site::file_type.updated'));
        }

        return $redirect;
    }

}