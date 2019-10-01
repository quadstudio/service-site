<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Concerns\StoreImages;
use QuadStudio\Service\Site\Filters\Event\ConfirmedSelectFilter;
use QuadStudio\Service\Site\Filters\Event\EventDateFromFilter;
use QuadStudio\Service\Site\Filters\Event\EventDateToFilter;
use QuadStudio\Service\Site\Filters\Event\EventPerPageFilter;
use QuadStudio\Service\Site\Filters\Event\EventShowFerroliBoolFilter;
use QuadStudio\Service\Site\Filters\Event\EventShowLamborghiniBoolFilter;
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

class EventController extends Controller
{

    use AuthorizesRequests, StoreImages;
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->events->trackFilter();
        $this->events->pushTrackFilter(SearchFilter::class);
        $this->events->pushTrackFilter(EventShowFerroliBoolFilter::class);
        $this->events->pushTrackFilter(EventShowLamborghiniBoolFilter::class);
        $this->events->pushTrackFilter(SortCreatedAtFilter::class);
        $this->events->pushTrackFilter(TypeSelectFilter::class);
        $this->events->pushTrackFilter(StatusSelectFilter::class);
        $this->events->pushTrackFilter(RegionSelectFilter::class);
        $this->events->pushTrackFilter(ConfirmedSelectFilter::class);
        $this->events->pushTrackFilter(EventDateFromFilter::class);
        $this->events->pushTrackFilter(EventDateToFilter::class);
        $this->events->pushTrackFilter(HasMembersSelectFilter::class);
        $this->events->pushTrackFilter(EventPerPageFilter::class);


        return view('site::admin.event.index', [
            'repository' => $this->events,
            'events'     => $this->events->paginate($request->input('filter.per_page', config('site.per_page.event', 10)), ['events.*'])
        ]);
    }

    /**
     * @param EventRequest $request
     * @param Member $member
     * @return \Illuminate\Http\Response
     */
    public function create(EventRequest $request, Member $member)
    {
        $regions = $this->regions->applyFilter(new SelectFilter())->applyFilter(new SortFilter())->all();
        $event_types = $this->types->all();
        $statuses = $this->statuses->all();
        $image = $this->getImage($request);

        return view('site::admin.event.create', compact('regions', 'event_types', 'statuses', 'member', 'image'));
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
        //dd($request->all());
        $event = $this->events->create(array_merge(
            $request->input(['event']),
            [
                'confirmed'        => $request->filled('event.confirmed'),
                'show_ferroli'     => $request->filled('event.show_ferroli'),
                'show_lamborghini' => $request->filled('event.show_lamborghini')
            ]
        ));
        if ($member->exists) {
            $member->event()->associate($event);
            $member->save();
        }

        return redirect()->route('admin.events.show', $event)->with('success', trans('site::event.created'));
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
     * @param EventRequest $request
     * @param Event $event
     * @return \Illuminate\Http\Response
     */
    public function edit(EventRequest $request, Event $event)
    {

        $regions = $this->regions->applyFilter(new SelectFilter())->applyFilter(new SortFilter())->all();
        $event_types = $this->types->all();
        $statuses = $this->statuses->all();
        $image = $this->getImage($request, $event);

        return view('site::admin.event.edit', compact('event', 'event_types', 'regions', 'statuses', 'image'));
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
            $request->input(['event']),
            ['confirmed' => $request->filled('event.confirmed')],
            ['show_ferroli' => $request->filled('event.show_ferroli')],
            ['show_lamborghini' => $request->filled('event.show_lamborghini')]
        ));

        return redirect()->route('admin.events.show', $event)->with('success', trans('site::event.updated'));
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

	/**
	 * @param Event $event
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 * @throws \Exception
	 */
    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);
        if ($event->delete()) {
            Session::flash('success', trans('site::event.deleted'));
        } else {
            Session::flash('error', trans('site::event.error.deleted'));
        }
        $json['redirect'] = route('admin.events.index');

        return response()->json($json);
    }

}