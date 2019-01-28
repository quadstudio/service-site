<?php

namespace QuadStudio\Service\Site\Traits\Controllers;


use QuadStudio\Service\Site\Filters\Event\DateFromFilter;
use QuadStudio\Service\Site\Filters\Event\DateToFilter;
use QuadStudio\Service\Site\Filters\Event\EventRunnedFilter;
use QuadStudio\Service\Site\Filters\Event\RegionSelectFilter;
use QuadStudio\Service\Site\Filters\Event\SearchCityFilter;
use QuadStudio\Service\Site\Filters\Event\SortDateFromFilter;
use QuadStudio\Service\Site\Filters\Event\TypeSelectFilter;
use QuadStudio\Service\Site\Models\Event;
use QuadStudio\Service\Site\Repositories\EventRepository;

trait EventControllerTrait
{
    protected $events;

    /**
     * Create a new controller instance.
     *
     * @param EventRepository $events
     */
    public function __construct(EventRepository $events)
    {
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
        $this->events->pushTrackFilter(RegionSelectFilter::class);
        $this->events->pushTrackFilter(SearchCityFilter::class);
        $this->events->pushTrackFilter(TypeSelectFilter::class);
        $this->events->pushTrackFilter(DateFromFilter::class);
        $this->events->pushTrackFilter(DateToFilter::class);

        return view('site::event.index', [
            'repository' => $this->events,
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