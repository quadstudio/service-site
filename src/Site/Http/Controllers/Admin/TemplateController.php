<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Http\Requests\Admin\TemplateRequest;
use QuadStudio\Service\Site\Models\Template;
use QuadStudio\Service\Site\Repositories\TemplateRepository;
use QuadStudio\Service\Site\Repositories\TemplateTypeRepository;

class TemplateController extends Controller
{
    /**
     * @var TemplateRepository
     */
    private $templates;
    /**
     * @var TemplateTypeRepository
     */
    private $types;


    /**
     * Create a new controller instance.
     *
     * @param TemplateRepository $templates
     * @param TemplateTypeRepository $types
     */
    public function __construct(
        TemplateRepository $templates,
        TemplateTypeRepository $types
    )
    {

        $this->templates = $templates;
        $this->types = $types;
    }

    /**
     * Show the shop index template
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->templates->trackFilter();

        return view('site::admin.template.index', [
            'repository' => $this->templates,
            'templates'  => $this->templates->paginate(config('site.per_template.template', 10), ['templates.*'])
        ]);
    }

    public function create()
    {
        $types = $this->types->all();

        return view('site::admin.template.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TemplateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TemplateRequest $request)
    {

        $this->templates->create($request->except(['_token', '_method', '_create']));
        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('admin.templates.create')->with('success', trans('site::template.created'));
        } else {
            $redirect = redirect()->route('admin.templates.index')->with('success', trans('site::template.created'));
        }

        return $redirect;
    }


    /**
     * @param Template $template
     * @return \Illuminate\Http\Response
     */
    public function edit(Template $template)
    {
        $types = $this->types->all();

        return view('site::admin.template.edit', compact('template', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TemplateRequest $request
     * @param  Template $template
     * @return \Illuminate\Http\Response
     */
    public function update(TemplateRequest $request, Template $template)
    {

        $template->update($request->except(['_method', '_token', '_stay']));

        if ($request->input('_stay') == 1) {

            $redirect = redirect()->route('admin.templates.edit', $template)->with('success', trans('site::template.updated'));
        } else {
            $redirect = redirect()->route('admin.templates.index')->with('success', trans('site::template.updated'));
        }

        return $redirect;
    }

    public function show(Request $request, Template $template)
    {

        if ($request->ajax()) {
            return response()->json($template->toArray());
        }

        return view('site::admin.template.show', compact('template'));
    }

    public function destroy(Template $template)
    {

        if ($template->delete()) {
            return redirect()->route('admin.templates.index')->with('success', trans('site::template.deleted'));
        } else {
            return redirect()->route('admin.templates.show', $template)->with('error', trans('site::template.error.deleted'));
        }
    }

}