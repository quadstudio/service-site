<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Models\Cost;
use QuadStudio\Service\Site\Repositories\CostRepository;

trait CostControllerTrait
{

    protected $costs;

    /**
     * Create a new controller instance.
     *
     * @param CostRepository $costs
     */
    public function __construct(CostRepository $costs)
    {
        $this->costs = $costs;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->costs->trackFilter();
        return view('site::cost.index', [
            'repository' => $this->costs,
            'items'      => $this->costs->paginate(config('site.per_page.cost', 10), ['costs.*'])
        ]);
    }

    public function show(Cost $cost)
    {
        return view('site::cost.show', ['cost' => $cost]);
    }
}