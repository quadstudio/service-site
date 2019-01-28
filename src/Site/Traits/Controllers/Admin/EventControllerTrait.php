<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;


use QuadStudio\Service\Site\Filters\Event\ConfirmedSelectFilter;
use QuadStudio\Service\Site\Filters\Event\DateFromFilter;
use QuadStudio\Service\Site\Filters\Event\DateToFilter;
use QuadStudio\Service\Site\Filters\Event\HasMembersSelectFilter;
use QuadStudio\Service\Site\Filters\Event\RegionSelectFilter;
use QuadStudio\Service\Site\Filters\Event\SearchFilter;
use QuadStudio\Service\Site\Filters\Event\SortCreatedAtFilter;
use QuadStudio\Service\Site\Filters\Event\StatusSelectFilter;
use QuadStudio\Service\Site\Filters\Event\TypeSelectFilter;
use QuadStudio\Service\Site\Filters\Member\EventFilter;
use QuadStudio\Service\Site\Filters\Region\SelectFilter;
use QuadStudio\Service\Site\Filters\Region\SortFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\EventRequest;
use QuadStudio\Service\Site\Models\Event;
use QuadStudio\Service\Site\Models\Member;
use QuadStudio\Service\Site\Repositories\EventRepository;
use QuadStudio\Service\Site\Repositories\EventStatusRepository;
use QuadStudio\Service\Site\Repositories\EventTypeRepository;
use QuadStudio\Service\Site\Repositories\MemberRepository;
use QuadStudio\Service\Site\Repositories\RegionRepository;
use QuadStudio\Service\Site\Repositories\TemplateRepository;

trait EventControllerTrait
{
    /**
     * @var EventRepository
     */
    protected $events;
    /**
     * @var EventTypeRepository
     */
    protected $types;
    /**
     * @var RegionRepository
     */
    protected $regions;

    /**
     * @var EventStatusRepository
     */
    protected $statuses;
    /**
     * @var TemplateRepository
     */
    private $templates;
    /**
     * @var MemberRepository
     */
    private $members;

    /**
     * Create a new controller instance.
     *
     * @param EventRepository $events
     * @param RegionRepository $regions
     * @param EventTypeRepository $types
     * @param EventStatusRepository $statuses
     * @param TemplateRepository $templates
     * @param MemberRepository $members
     */
    public function __construct(
        EventRepository $events,
        RegionRepository $regions,
        EventTypeRepository $types,
        EventStatusRepository $statuses,
        TemplateRepository $templates,
        MemberRepository $members
    )
    {
        $this->events = $events;
        $this->regions = $regions;
        $this->types = $types;
        $this->statuses = $statuses;
        $this->templates = $templates;
        $this->members = $members;
    }

    /**
     * Show the events index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->events->trackFilter();
        $this->events->pushTrackFilter(SearchFilter::class);
        $this->events->pushTrackFilter(SortCreatedAtFilter::class);
        $this->events->pushTrackFilter(TypeSelectFilter::class);
        $this->events->pushTrackFilter(StatusSelectFilter::class);
        $this->events->pushTrackFilter(RegionSelectFilter::class);
        $this->events->pushTrackFilter(HasMembersSelectFilter::class);
        $this->events->pushTrackFilter(DateFromFilter::class);
        $this->events->pushTrackFilter(DateToFilter::class);
        $this->events->pushTrackFilter(ConfirmedSelectFilter::class);


        return view('site::admin.event.index', [
            'repository' => $this->events,
            'events'     => $this->events->paginate(config('site.per_page.event', 10), ['events.*'])
        ]);
    }

    /**
     * @param Member $member
     * @return \Illuminate\Http\Response
     */
    public function create(Member $member)
    {
        $regions = $this->regions->applyFilter(new SelectFilter())->applyFilter(new SortFilter())->all();
        $types = $this->types->all();
        $statuses = $this->statuses->all();

        return view('site::admin.event.create', compact('regions', 'types', 'statuses', 'member'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EventRequest $request
     * @param Member $member
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request, Member $member)
    {

        $event = $this->events->create(array_merge(
            $request->except(['_method', '_token', '_create']),
            [
                'confirmed' => $request->filled('confirmed') ? 1 : 0
            ]
        ));
        if ($member->exists) {
            $member->event()->associate($event);
            $member->save();
        }
        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('admin.events.create')->with('success', trans('site::event.created'));
        } else {
            $redirect = redirect()->route('admin.events.show', $event)->with('success', trans('site::event.created'));
        }

        return $redirect;
    }

    /**
     * @param Event $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {

        return view('site::admin.event.show', compact('event'));
    }



    public function attachment()
    {
        $random = mt_rand(10000, 50000);

        return response()->view('site::admin.event.notify.attachment', compact('random'));
    }

    /**
     * @param Event $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {

        $regions = $this->regions->applyFilter(new SelectFilter())->applyFilter(new SortFilter())->all();
        $types = $this->types->all();
        $statuses = $this->statuses->all();

        return view('site::admin.event.edit', compact('event', 'types', 'regions', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EventRequest $request
     * @param  Event $event
     * @return \Illuminate\Http\Response
     */
    public function update(EventRequest $request, Event $event)
    {

        $event->update(array_merge(
            $request->except(['_method', '_token', '_stay']),
            [
                'confirmed' => $request->filled('confirmed') ? 1 : 0
            ]
        ));

        if ($request->input('_stay') == 1) {

            $redirect = redirect()->route('admin.events.edit', $event)->with('success', trans('site::event.updated'));
        } else {
            $redirect = redirect()->route('admin.events.show', $event)->with('success', trans('site::event.updated'));
        }

        return $redirect;
    }

    /**
     * @param Event $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function mailing(Event $event)
    {
        $templates = $this->templates->all();

        $headers = collect([
            trans('site::member.contact'),
            trans('site::member.phone'),
            trans('site::member.name')
        ]);

        $emails = collect([]);
        $this->members->trackFilter();
        $this->members->applyFilter((new EventFilter())->setEvent($event));
        $repository = $this->members;

        /** @var Member $member */
        foreach ($this->members->all() as $member) {
            $emails->push([
                'email'    => $member->getAttribute('email'),
                'verified' => $member->getAttribute('verified'),
                'extra'    => [
                    'contact' => $member->getAttribute('contact'),
                    'phone'   => $member->getAttribute('phone'),
                    'name'    => $member->getAttribute('name')
                ]
            ]);
        }
        $route = route('admin.events.show', $event);

        return view('site::admin.event.mailing', compact('event', 'headers', 'emails', 'templates', 'route', 'repository'));
    }

}