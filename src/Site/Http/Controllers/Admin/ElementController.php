<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Http\Requests\Admin\ElementRequest;
use QuadStudio\Service\Site\Models\Element;
use QuadStudio\Service\Site\Repositories\ElementRepository;

class ElementController extends Controller
{

    protected $elements;

    /**
     * Create a new controller instance.
     *
     * @param ElementRepository $elements
     */
    public function __construct(ElementRepository $elements)
    {
        $this->elements = $elements;
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->elements->trackFilter();

        return view('site::admin.element.index', [
            'repository' => $this->elements,
            'elements'  => $this->elements->paginate(config('site.per_page.element', 10), ['elements.*'])
        ]);
    }

    public function create()
    {
        return view('site::admin.element.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ElementRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ElementRequest $request)
    {

        //dd($request->all());
        $element = $this->elements->create($request->except(['_token', '_method', '_create']));
        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('admin.elements.create')->with('success', trans('site::element.created'));
        } else {
            $redirect = redirect()->route('admin.elements.index')->with('success', trans('site::element.created'));
        }

        return $redirect;
    }


    /**
     * @param Element $element
     * @return \Illuminate\Http\Response
     */
    public function edit(Element $element)
    {
        return view('site::admin.element.edit', compact('element'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ElementRequest $request
     * @param  Element $element
     * @return \Illuminate\Http\Response
     */
    public function update(ElementRequest $request, Element $element)
    {

        $element->update($request->except(['_method', '_token', '_stay']));

        if ($request->input('_stay') == 1) {

            $redirect = redirect()->route('admin.elements.edit', $element)->with('success', trans('site::element.updated'));
        } else {
            $redirect = redirect()->route('admin.elements.index')->with('success', trans('site::element.updated'));
        }

        return $redirect;
    }

    public function sort(Request $request)
    {
        $sort = array_flip($request->input('sort'));

        foreach ($sort as $element_id => $sort_order) {
            /** @var Element $element */
            $element = Element::find($element_id);
            $element->setAttribute('sort_order', $sort_order);
            $element->save();
        }
    }


}