<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Http\Requests\Admin\PageRequest;
use QuadStudio\Service\Site\Models\Page;
use QuadStudio\Service\Site\Repositories\PageRepository;

class PageController extends Controller
{

    protected $pages;

    /**
     * Create a new controller instance.
     *
     * @param PageRepository $pages
     */
    public function __construct(PageRepository $pages)
    {
        $this->pages = $pages;
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->pages->trackFilter();

        return view('site::admin.page.index', [
            'repository' => $this->pages,
            'pages'  => $this->pages->paginate(config('site.per_page.page', 10), ['pages.*'])
        ]);
    }

    public function create()
    {
        return view('site::admin.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {

        //dd($request->all());
        $page = $this->pages->create($request->except(['_token', '_method', '_create']));
        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('admin.pages.create')->with('success', trans('site::page.created'));
        } else {
            $redirect = redirect()->route('admin.pages.index')->with('success', trans('site::page.created'));
        }

        return $redirect;
    }


    /**
     * @param Page $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('site::admin.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PageRequest $request
     * @param  Page $page
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Page $page)
    {

        $page->update($request->except(['_method', '_token', '_stay']));

        if ($request->input('_stay') == 1) {

            $redirect = redirect()->route('admin.pages.edit', $page)->with('success', trans('site::page.updated'));
        } else {
            $redirect = redirect()->route('admin.pages.index')->with('success', trans('site::page.updated'));
        }

        return $redirect;
    }

    public function show(Page $page)
    {

        return view('site::admin.page.show', compact('page'));
    }

    public function destroy(Page $page)
    {

        if ($page->delete()) {
            return redirect()->route('admin.pages.index')->with('success', trans('site::page.deleted'));
        } else {
            return redirect()->route('admin.pages.show', $page)->with('error', trans('site::page.error.deleted'));
        }
    }

}