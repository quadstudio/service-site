<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Models\Country;
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $random = mt_rand(10000, 50000);
        $countries = Country::query()->where('enabled', 1)->orderBy('name')->get();
        return response()->view('site::participant.create', compact('random', 'countries'));
    }


}