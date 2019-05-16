<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\Event\EventDateFromFilter;
use QuadStudio\Service\Site\Filters\Event\EventDateToFilter;
use QuadStudio\Service\Site\Filters\Event\EventRunnedFilter;
use QuadStudio\Service\Site\Filters\Event\EventTypeFilter;
use QuadStudio\Service\Site\Filters\Event\RegionSelectFilter;
use QuadStudio\Service\Site\Filters\Event\SearchCityFilter;
use QuadStudio\Service\Site\Filters\Event\SortDateFromFilter;
use QuadStudio\Service\Site\Filters\EventType\EventTypePerPageFilter;
use QuadStudio\Service\Site\Models\EventType;
use QuadStudio\Service\Site\Repositories\EventRepository;
use QuadStudio\Service\Site\Repositories\EventTypeRepository;

class EventTypeController extends Controller
{

    private $events;
    private $event_types;

    /**
     * Create a new controller instance.
     *
     * @param EventRepository $events
     * @param EventTypeRepository $event_types
     */
    public function __construct(EventRepository $events, EventTypeRepository $event_types)
    {
        $this->event_types = $event_types;
        $this->events = $events;
    }

    /**
     * @param Request $request
     * @param EventType $event_type
     * @return \Illuminate\Http\Response
     * @internal param Event $event
     */
    public function show(Request $request, EventType $event_type)
    {
        if ($event_type->getAttribute(config('site.check_field', 'show_ferroli')) === false) {
            abort(404);
        }

        $this->events
            ->trackFilter()
            ->applyFilter(new SortDateFromFilter())
            ->applyFilter(new EventRunnedFilter())
            ->applyFilter((new EventTypeFilter())->setEventType($event_type))
            ->pushTrackFilter(RegionSelectFilter::class)
            ->pushTrackFilter(SearchCityFilter::class)
            ->pushTrackFilter(EventDateFromFilter::class)
            ->pushTrackFilter(EventDateToFilter::class)
            ->pushTrackFilter(EventTypePerPageFilter::class);

        return view('site::event_type.show', [
            'repository' => $this->events,
            'event_type' => $event_type,
            'events'     => $this->events->paginate($request->input('filter.per_page', config('site.per_page.event', 10)), ['events.*'])
        ]);
    }

}