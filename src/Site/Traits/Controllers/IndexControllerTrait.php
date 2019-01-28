<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters;
use QuadStudio\Service\Site\Filters\Event\EventRunnedFilter;
use QuadStudio\Service\Site\Filters\Event\SortDateFromFilter;
use QuadStudio\Service\Site\Repositories\EventRepository;
use QuadStudio\Service\Site\Repositories\EventTypeRepository;
use QuadStudio\Service\Site\Repositories\NewsRepository;

trait IndexControllerTrait
{

    /**
     * @var NewsRepository
     */
    protected $news;
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
     * @param NewsRepository $news
     * @param EventRepository $events
     * @param EventTypeRepository $types
     */
    public function __construct(
        NewsRepository $news,
        EventRepository $events,
        EventTypeRepository $types
    )
    {
        $this->news = $news;
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
        $news = $this->news
            ->applyFilter(new Filters\News\SortDateFilter())
            ->applyFilter(new Filters\News\PublishedFilter())
            ->applyFilter(new Filters\News\LimitSixFilter())
            ->all(['news.*']);
        $events = $this->events
            ->applyFilter(new SortDateFromFilter())
            ->applyFilter(new EventRunnedFilter())
//            ->applyFilter(new SortDateFilter())
//            ->applyFilter(new PublishedFilter())
//            ->applyFilter(new LimitSixFilter())
            ->all(['events.*']);
        $types = $this->types
            ->applyFilter(new Filters\EventType\SortFilter())
            ->applyFilter(new Filters\EventType\ActiveFilter())
            ->all(['event_types.*']);

        return view('site::index', compact('news', 'events', 'types'));

    }
}