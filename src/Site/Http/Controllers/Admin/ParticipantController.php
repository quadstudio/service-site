<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;


use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Http\Requests\Admin\ParticipantRequest;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Member;
use QuadStudio\Service\Site\Models\Participant;
use QuadStudio\Service\Site\Repositories\ParticipantRepository;

class ParticipantController extends Controller
{
    /**
     * @var ParticipantRepository
     */
    private $participants;

    /**
     * Create a new controller instance.
     *
     * @param ParticipantRepository $participants
     */
    public function __construct(
        ParticipantRepository $participants
    )
    {
        $this->participants = $participants;
    }

    /**
     * @param Member $member
     * @return \Illuminate\Http\Response
     */
    public function create(Member $member)
    {
        $countries = Country::query()->where('enabled', 1)->orderBy('name')->get();
        return view('site::admin.participant.create', compact('member', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ParticipantRequest $request
     * @param Member $member
     * @return \Illuminate\Http\Response
     */
    public function store(ParticipantRequest $request, Member $member)
    {
        $member->participants()->save(Participant::query()->create($request->input('participant'))->getModel());

        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('admin.participants.create', $member)->with('success', trans('site::participant.created'));
        } else {
            $redirect = redirect()->route('admin.members.show', $member)->with('success', trans('site::participant.created'));
        }

        return $redirect;
    }

    public function destroy(Participant $participant)
    {

        if ($participant->delete()) {
            $json['remove'][] = '#participant-' . $participant->id;
        } else {
            $json['error'][] = 'error';
        }

        return response()->json($json);
    }

}