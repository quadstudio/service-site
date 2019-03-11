<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters;
use QuadStudio\Service\Site\Filters\Event\DateFromFilter;
use QuadStudio\Service\Site\Filters\Event\DateToFilter;
use QuadStudio\Service\Site\Filters\Event\EventRunnedFilter;
use QuadStudio\Service\Site\Filters\Event\EventFdFilter;
use QuadStudio\Service\Site\Filters\Event\RegionSelectFilter;
use QuadStudio\Service\Site\Filters\Event\SearchCityFilter;
use QuadStudio\Service\Site\Filters\Event\SortDateFromFilter;
use QuadStudio\Service\Site\Filters\Event\TypeSelectFilter;
use QuadStudio\Service\Site\Models\Event;
use QuadStudio\Service\Site\Repositories\EventRepository;
use QuadStudio\Service\Site\Repositories\EventTypeRepository;

trait EventFdControllerTrait
{
    private $types;
	protected $events;
	

    /**
     * Create a new controller instance.
     *
     * @param EventRepository $events
     */
    public function __construct(EventRepository $events, EventTypeRepository $types)
    {	
		$this->types = $types;
        $this->events = $events;
    }

    /**
     * Show the events index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->events->trackFilter();
        $this->events->applyFilter(new SortDateFromFilter());
        $this->events->applyFilter(new EventRunnedFilter());
        $this->events->applyFilter(new EventFdFilter());
        $this->events->pushTrackFilter(RegionSelectFilter::class);
        $this->events->pushTrackFilter(DateFromFilter::class);
        $this->events->pushTrackFilter(DateToFilter::class);

		 $types = $this->types
            ->applyFilter(new Filters\EventType\SortFilter())
            ->applyFilter(new Filters\EventType\ActiveFilter())
            ->all(['event_types.*']);
		
        return view('site::event.index_fsf', [
            'repository' => $this->events,
            'types' => $types->where('id', 3),
            'events'     => $this->events->paginate(config('site.per_page.event', 15), ['events.*'])
        ]);
    }

    /**
     * @param Event $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('site::event.show', compact('event'));
    }

}
