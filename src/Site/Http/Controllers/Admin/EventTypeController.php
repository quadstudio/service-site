<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Concerns\Sortable;
use QuadStudio\Service\Site\Concerns\StoreImages;
use QuadStudio\Service\Site\Http\Requests\Admin\EventTypeRequest;
use QuadStudio\Service\Site\Models\EventType;
use QuadStudio\Service\Site\Repositories\EventTypeRepository;

class EventTypeController extends Controller
{
    use Sortable, StoreImages;
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
        $event_types = EventType::query()->orderBy('sort_order')->get();

        return view('site::admin.event_type.index', compact('event_types'));
    }


    public function create(EventTypeRequest $request)
    {
        $image = $this->getImage($request);

        return view('site::admin.event_type.create', compact('image'));
    }


    public function show(EventType $event_type)
    {
        return view('site::admin.event_type.show', compact('event_type'));
    }


    /**
     * @param EventType $event_type
     * @return \Illuminate\Http\Response
     */
    public function edit(EventTypeRequest $request, EventType $event_type)
    {
        $image = $this->getImage($request, $event_type);

        return view('site::admin.event_type.edit', compact('event_type', 'image'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EventTypeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventTypeRequest $request)
    {

        $event_type = $this->event_types->create(array_merge(
            $request->input('event_type'),
            [
                'show_ferroli'     => $request->filled('event_type.show_ferroli'),
                'show_lamborghini' => $request->filled('event_type.show_lamborghini'),
                'sort_order'       => EventType::all()->count()
            ]
        ));

        return redirect()->route('admin.event_types.show', $event_type)->with('success', trans('site::event_type.created'));
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
            $request->input('event_type'),
            [
                'show_ferroli'     => $request->filled('event_type.show_ferroli'),
                'show_lamborghini' => $request->filled('event_type.show_lamborghini'),
            ]
        ));

        return redirect()->route('admin.event_types.show', $event_type)->with('success', trans('site::event_type.updated'));
    }

}