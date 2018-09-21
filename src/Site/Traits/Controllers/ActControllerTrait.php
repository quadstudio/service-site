<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Repositories\ActRepository;
use QuadStudio\Service\Site\Models\Act;

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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->acts->trackFilter();
        $this->acts->applyFilter(new BelongsUserFilter());
        return view('site::act.index', [
            'repository' => $this->acts,
            'acts'      => $this->acts->paginate(config('site.per_page.act', 10), ['acts.*'])
        ]);
    }

    public function show(Act $act)
    {
        $this->authorize('view', $act);
        return view('site::act.show', compact('act'));
    }
}