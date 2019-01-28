<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;


use QuadStudio\Service\Site\Http\Requests\Admin\ParticipantRequest;
use QuadStudio\Service\Site\Models\Member;
use QuadStudio\Service\Site\Models\Participant;
use QuadStudio\Service\Site\Repositories\ParticipantRepository;

trait ParticipantControllerTrait
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
        return view('site::admin.participant.create', compact('member'));
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
        $member->participants()->save(Participant::create($request->except(['_method', '_token', '_create'])));

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