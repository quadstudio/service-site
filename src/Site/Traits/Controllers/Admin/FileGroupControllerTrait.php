<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Http\Requests\Admin\FileGroupRequest;
use QuadStudio\Service\Site\Models\FileGroup;
use QuadStudio\Service\Site\Repositories\FileGroupRepository;

trait FileGroupControllerTrait
{

    /**
     * @var FileGroupRepository
     */
    private $groups;

    /**
     * Create a new controller instance.
     *
     * @param FileGroupRepository $groups
     */
    public function __construct(FileGroupRepository $groups)
    {
        $this->groups = $groups;
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->groups->trackFilter();

        return view('site::admin.file_group.index', [
            'repository' => $this->groups,
            'groups'      => $this->groups->paginate(config('site.per_page.file_group', 25), ['file_groups.*'])
        ]);
    }

    public function create()
    {
        $groups = $this->groups->all();

        return view('site::admin.file_group.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FileGroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileGroupRequest $request)
    {

        //dd($request->all());
        $file_group = $this->groups->create($request->except(['_method', '_token', '_create']));
        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('admin.file_groups.create')->with('success', trans('site::file_group.created'));
        } else {
            $redirect = redirect()->route('admin.file_groups.show', $file_group)->with('success', trans('site::file_group.created'));
        }

        return $redirect;
    }

    public function show(FileGroup $file_group)
    {
        return view('site::admin.file_group.show', compact('file_group'));
    }

    public function edit(FileGroup $file_group)
    {
        return view('site::admin.file_group.edit', compact('file_group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FileGroupRequest $request
     * @param  FileGroup $file_group
     * @return \Illuminate\Http\Response
     */
    public function update(FileGroupRequest $request, FileGroup $file_group)
    {
        $file_group->update($request->except(['_method', '_token', '_stay']));
        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('admin.file_groups.edit', $file_group)->with('success', trans('site::file_group.updated'));
        } else {
            $redirect = redirect()->route('admin.file_groups.show', $file_group)->with('success', trans('site::file_group.updated'));
        }

        return $redirect;
    }

}