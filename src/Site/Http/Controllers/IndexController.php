<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters;
use QuadStudio\Service\Site\Filters\Event\EventRunnedFilter;
use QuadStudio\Service\Site\Filters\Event\SortDateFromFilter;
use QuadStudio\Service\Site\Repositories\EventRepository;
use QuadStudio\Service\Site\Repositories\EventTypeRepository;
use QuadStudio\Service\Site\Repositories\AnnouncementRepository;

class IndexController extends Controller
{

    /**
     * @var AnnouncementRepository
     */
    protected $announcements;
    /**
     * @var EventRepository
     */
    private $events;
    /**
     * @var EventTypeRepository
     */
    private $types;

    /**
     * Create a new controller instance.
     *
     * @param AnnouncementRepository $announcements
     * @param EventRepository $events
     * @param EventTypeRepository $types
     */
    public function __construct(
        AnnouncementRepository $announcements,
        EventRepository $events,
        EventTypeRepository $types
    )
    {
        $this->announcements = $announcements;
        $this->events = $events;
        $this->types = $types;
    }

    /**
     * Show application index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $announcements = $this->announcements
            ->applyFilter(new Filters\Announcement\SortDateFilter())
            ->applyFilter(new Filters\Announcement\PublishedFilter())
            ->applyFilter(new Filters\Announcement\LimitSixFilter())
            ->all(['announcements.*']);
        $events = $this->events
            ->applyFilter(new SortDateFromFilter())
            ->applyFilter(new EventRunnedFilter())
//            ->applyFilter(new SortDateFilter())
//            ->applyFilter(new PublishedFilter())
//            ->applyFilter(new LimitSixFilter())
            ->all(['events.*']);
        $event_types = $this->types
            ->applyFilter(new Filters\EventType\SortFilter())
            ->applyFilter(new Filters\EventType\EventTypeShowFilter())
            ->all(['event_types.*']);

        return view('site::index', compact('announcements', 'events', 'event_types'));

    }
}