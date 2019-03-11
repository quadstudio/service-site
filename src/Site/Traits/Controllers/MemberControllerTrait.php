<?php

namespace QuadStudio\Service\Site\Traits\Controllers;


use Illuminate\Http\Request;
use QuadStudio\Service\Site\Events\MemberCreateEvent;
use QuadStudio\Service\Site\Filters\Event\EventRunnedFilter;
use QuadStudio\Service\Site\Filters\Event\SortDateFromFilter;
use QuadStudio\Service\Site\Filters\Member\DateFromFilter;
use QuadStudio\Service\Site\Filters\Member\DateToFilter;
use QuadStudio\Service\Site\Filters\Member\MemberRunnedFilter;
use QuadStudio\Service\Site\Filters\Member\MemberVerifiedFilter;
use QuadStudio\Service\Site\Filters\Member\RegionSelectFilter;
use QuadStudio\Service\Site\Filters\Member\SearchCityFilter;
use QuadStudio\Service\Site\Filters\Member\SortDateFromAscFilter;
use QuadStudio\Service\Site\Filters\Member\TypeSelectFilter;
use QuadStudio\Service\Site\Filters\Region\SelectFilter;
use QuadStudio\Service\Site\Filters\Region\SortFilter;
use QuadStudio\Service\Site\Http\Requests\MemberRequest;
use QuadStudio\Service\Site\Models\Event;
use QuadStudio\Service\Site\Models\EventType;
use QuadStudio\Service\Site\Models\Member;
use QuadStudio\Service\Site\Repositories\EventRepository;
use QuadStudio\Service\Site\Repositories\EventTypeRepository;
use QuadStudio\Service\Site\Repositories\MemberRepository;
use QuadStudio\Service\Site\Repositories\RegionRepository;

trait MemberControllerTrait
{

    protected $members;
    /**
     * @var RegionRepository
     */
    private $regions;
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
     * @param MemberRepository $members
     * @param RegionRepository $regions
     * @param EventRepository $events
     * @param EventTypeRepository $types
     */
    public function __construct(
        MemberRepository $members,
        RegionRepository $regions,
        EventRepository $events,
        EventTypeRepository $types

    )
    {
        $this->members = $members;
        $this->regions = $regions;
        $this->events = $events;
        $this->types = $types;
    }

    /**
     * Show the news index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->members->trackFilter();
        $this->members->applyFilter(new MemberRunnedFilter());
        $this->members->applyFilter(new MemberVerifiedFilter());
        $this->members->applyFilter(new SortDateFromAscFilter());
        $this->members
            ->pushTrackFilter(SearchCityFilter::class)
            ->pushTrackFilter(RegionSelectFilter::class)
            ->pushTrackFilter(TypeSelectFilter::class)
            ->pushTrackFilter(DateFromFilter::class)
            ->pushTrackFilter(DateToFilter::class);

        return view('site::member.index', [
            'repository' => $this->members,
            'members'    => $this->members->paginate(config('site.per_page.member', 15), ['members.*'])
        ]);
    }

    public function create(Request $request)
    {
        $regions = $this->regions->applyFilter(new SelectFilter())->applyFilter(new SortFilter())->all();
        $events = $this->events->applyFilter(new SortDateFromFilter())->applyFilter(new EventRunnedFilter())->all();
        $types = $this->types->all();
        $event = Event::query()->findOrNew($request->input('event_id'));
        $type = EventType::query()->findOrNew($request->input('type_id'));

        return view('site::member.create', compact('regions', 'type', 'types', 'event', 'events'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MemberRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberRequest $request)
    {
        //dd($request->all());
        $member = $this->members->create($request->except(['_method', '_token', '_create', 'participant']));

        if ($request->filled('participant')) {
            $data = [];
            foreach ($request->input('participant') as $key => $participant) {
                $data[] = [
                    'name'         => $participant['name'],
                    'headposition' => $participant['headposition'],
                    'phone'        => $participant['phone'],
                    'email'        => $participant['email'],
                ];
            }

            $member->participants()->createMany($data);
        }

        event(new MemberCreateEvent($member));
        return redirect()->route('members.index')->with('success', trans('site::member.confirm_email', ['email' => $member->email]));
    }

    public function confirm($token)
    {
        Member::whereVerifyToken($token)->firstOrFail()->hasVerified();

        return redirect()->route('members.index')->with('success', trans('site::member.confirmed_email'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function participant()
    {
        $random = mt_rand(10000, 50000);

        return view('site::participant.create', compact('random'));
    }
}