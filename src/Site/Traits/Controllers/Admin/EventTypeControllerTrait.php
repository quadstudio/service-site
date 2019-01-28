<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Filters\EventType\SortFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\EventTypeRequest;
use QuadStudio\Service\Site\Models\EventType;
use QuadStudio\Service\Site\Repositories\EventTypeRepository;
use QuadStudio\Service\Site\Traits\Models\SortOrderTrait;

trait EventTypeControllerTrait
{
    use SortOrderTrait;
    /**
     * @var EventTypeRepository
     */
    protected $event_types;

    /**
     * Create a new controller instance.
     *
     * @param EventTypeRepository $event_types
     */
    public function __construct(EventTypeRepository $event_types)
    {
        $this->event_types = $event_types;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->event_types->applyFilter(new SortFilter());

        return view('site::admin.event_type.index', [
            'event_types' => $this->event_types->all(['event_types.*'])
        ]);
    }


    public function create()
    {
        return view('site::admin.event_type.create');
    }


    public function show(EventType $event_type)
    {
        return view('site::admin.event_type.show', compact('event_type'));
    }


    /**
     * @param EventType $event_type
     * @return \Illuminate\Http\Response
     */
    public function edit(EventType $event_type)
    {
        return view('site::admin.event_type.edit', compact('event_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EventTypeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventTypeRequest $request)
    {

        //dd($request->all());
        $event_type = $this->event_types->create(array_merge(
            $request->except(['_method', '_token', '_create']),
            [
                'active'  => $request->filled('active') ? 1 : 0,
                'sort_order' => EventType::all()->count()
            ]
        ));
        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('admin.event_types.create')->with('success', trans('site::event_type.created'));
        } else {
            $redirect = redirect()->route('admin.event_types.show', $event_type)->with('success', trans('site::event_type.created'));
        }

        return $redirect;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EventTypeRequest $request
     * @param  EventType $event_type
     * @return \Illuminate\Http\Response
     */
    public function update(EventTypeRequest $request, EventType $event_type)
    {
        $event_type->update(array_merge(
            $request->except(['_method', '_token', '_stay']),
            [
                'active'  => $request->filled('active') ? 1 : 0
            ]
        ));
        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('admin.event_types.edit', $event_type)->with('success', trans('site::event_type.updated'));
        } else {
            $redirect = redirect()->route('admin.event_types.show', $event_type)->with('success', trans('site::event_type.updated'));
        }

        return $redirect;
    }

}