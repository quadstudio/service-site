<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;

use QuadStudio\Service\Site\Http\Resources\ActResource;
use QuadStudio\Service\Site\Models\Act;
use QuadStudio\Service\Site\Repositories\ActRepository;

trait ActControllerTrait
{
    protected $acts;

    /**
     * Create a new controller instance.
     *
     * @param ActRepository $acts
     */
    public function __construct(ActRepository $acts)
    {
        $this->acts = $acts;
    }

    /**
     * Show the user profile
     */
    public function index()
    {
        //return new UserCollection($this->users->all());
    }

    /**
     * Display the specified resource.
     *
     * @param Act $act
     * @return ActResource
     */
    public function show(Act $act)
    {
        return new ActResource($act);
    }
}