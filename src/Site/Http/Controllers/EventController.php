<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\Event\EventDateFromFilter;
use QuadStudio\Service\Site\Filters\Event\EventDateToFilter;
use QuadStudio\Service\Site\Filters\Event\EventRunnedFilter;
use QuadStudio\Service\Site\Filters\Event\EventTypeFilter;
use QuadStudio\Service\Site\Filters\Event\RegionSelectFilter;
use QuadStudio\Service\Site\Filters\Event\TypeSelectFilter;
use QuadStudio\Service\Site\Filters\Event\SearchCityFilter;
use QuadStudio\Service\Site\Filters\Event\SortDateFromFilter;
use QuadStudio\Service\Site\Filters\EventType\EventTypePerPageFilter;
use QuadStudio\Service\Site\Models\Event;
use QuadStudio\Service\Site\Models\EventType;
use QuadStudio\Service\Site\Repositories\EventRepository;
use QuadStudio\Service\Site\Repositories\EventTypeRepository;

class EventController extends Controller
{


	public function __construct(EventRepository $events, EventTypeRepository $event_types)
    {
        $this->event_types = $event_types;
        $this->events = $events;
    }

    /**
     * @param Event $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        if($event->getAttribute(config('site.check_field')) === false){
            abort(404);
        }
        return view('site::event.show', compact('event'));
    }

	public function index()
    {

        $this->events->trackFilter();
        $this->events->applyFilter(new SortDateFromFilter());
        $this->events->applyFilter(new EventRunnedFilter());
        $this->events->pushTrackFilter(RegionSelectFilter::class);
        $this->events->pushTrackFilter(SearchCityFilter::class);
        $this->events->pushTrackFilter(TypeSelectFilter::class);
        $this->events->pushTrackFilter(EventDateFromFilter::class);
        $this->events->pushTrackFilter(EventDateToFilter::class);

       $this->event_types;

        return view('site::event.index', [
            'repository' => $this->events,
            'events'     => $this->events->paginate(config('site.per_page.event', 30), ['events.*']),
	    'types'	 => $this->event_types->all(['event_types.*'])
        ]);
    }



}