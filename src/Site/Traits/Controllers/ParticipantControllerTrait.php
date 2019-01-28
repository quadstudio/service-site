<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $random = mt_rand(10000, 50000);

        return response()->view('site::participant.create', compact('random'));
    }


}