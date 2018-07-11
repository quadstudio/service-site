<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

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
        return view('site::act.index', [
            'repository' => $this->acts,
            'items'      => $this->acts->paginate(config('site.per_page.act', 10), [env('DB_PREFIX', '').'acts.*'])
        ]);
    }

    public function show(Act $act)
    {
        return view('site::act.show', ['act' => $act]);
    }
}