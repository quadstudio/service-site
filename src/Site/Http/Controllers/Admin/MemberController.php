<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\Member\MemberDateFromFilter;
use QuadStudio\Service\Site\Filters\Member\MemberDateToFilter;
use QuadStudio\Service\Site\Filters\Member\MemberRegionSelectFilter;
use QuadStudio\Service\Site\Filters\Member\MemberSearchCityFilter;
use QuadStudio\Service\Site\Filters\Member\MemberTypeSelectFilter;
use QuadStudio\Service\Site\Filters\Member\SearchFilter;
use QuadStudio\Service\Site\Filters\Member\SortSelectFilter;
use QuadStudio\Service\Site\Filters\Member\StatusSelectFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\MemberRequest;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Event;
use QuadStudio\Service\Site\Models\EventType;
use QuadStudio\Service\Site\Models\Member;
use QuadStudio\Service\Site\Models\MemberStatus;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Repositories\MemberRepository;

class MemberController extends Controller
{
    /**
     * @var MemberRepository
     */
    protected $members;


    /**
     * Create a new controller instance.
     *
     * @param MemberRepository $members
     */
    public function __construct(MemberRepository $members)
    {
        $this->members = $members;
    }

    /**
     * Show the members index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->members->trackFilter();
        $this->members->pushTrackFilter(MemberSearchCityFilter::class);
        $this->members->pushTrackFilter(SearchFilter::class);
        $this->members->pushTrackFilter(StatusSelectFilter::class);
        $this->members->pushTrackFilter(MemberTypeSelectFilter::class);
        $this->members->pushTrackFilter(MemberRegionSelectFilter::class);
        $this->members->pushTrackFilter(MemberDateFromFilter::class);
        $this->members->pushTrackFilter(MemberDateToFilter::class);
        $this->members->pushTrackFilter(SortSelectFilter::class);

        return view('site::admin.member.index', [
            'repository' => $this->members,
            'members'    => $this->members->paginate(config('site.per_page.member', 10), ['members.*'])
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $countries = Country::query()->where('enabled', 1)->orderBy('name')->get();
        $regions = Region::query()->whereHas('country', function ($country) {
            $country->where('enabled', 1);
        })->orderBy('name')->get();
        $member_events = Event::query()->orderBy('created_at', 'DESC')->get();
        $member_statuses = MemberStatus::query()->orderBy('sort_order', 'ASC')->get();
        $member_types = EventType::query()->get();
        $event = Event::query()->findOrNew($request->input('event_id'));

        return view('site::admin.member.create', compact('regions', 'member_types', 'event',
            'member_events', 'member_statuses', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MemberRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberRequest $request)
    {

        $member = $this->members->create(array_merge(
            $request->input(['member']),
            [
                'verified'         => $request->filled('member.verified'),
                'show_ferroli'     => $request->filled('member.show_ferroli'),
                'show_lamborghini' => $request->filled('member.show_lamborghini')
            ]
        ));

        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('admin.participants.create', $member)->with('success', trans('site::member.created'));
        } else {
            $redirect = redirect()->route('admin.members.show', $member)->with('success', trans('site::member.created'));
        }

        return $redirect;
    }

    public function show(Member $member)
    {
        $member
            ->with('type')
            ->with('status')
            ->with('event')
            ->with('region');

        return view('site::admin.member.show', compact('member'));
    }

    public function edit(Member $member)
    {

        $countries = Country::query()->where('enabled', 1)->orderBy('name')->get();
        $regions = Region::query()->whereHas('country', function ($country) {
            $country->where('enabled', 1);
        })->orderBy('name')->get();
        $member_events = Event::query()->orderBy('created_at', 'DESC')->get();
        $member_statuses = MemberStatus::query()->orderBy('sort_order', 'ASC')->get();
        $member_types = EventType::query()->get();


        return view('site::admin.member.edit', compact('member', 'member_types', 'regions',
            'member_events', 'member_statuses', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MemberRequest $request
     * @param  Member $member
     * @return \Illuminate\Http\Response
     */
    public function update(MemberRequest $request, Member $member)
    {
        $data = $request->input('member');
        if ($request->input('verified') == 1) {
            $data['verify_token'] = null;
        }
        $member->update(array_merge(
            $request->input(['member']),
            [
                'verified'         => $request->filled('member.verified'),
                'show_ferroli'     => $request->filled('member.show_ferroli'),
                'show_lamborghini' => $request->filled('member.show_lamborghini')
            ]
        ));

        return redirect()->route('admin.members.show', $member)->with('success', trans('site::member.updated'));
    }

    public function participants(Member $member)
    {
        return view('site::admin.member.participants', compact('member'));
    }


}