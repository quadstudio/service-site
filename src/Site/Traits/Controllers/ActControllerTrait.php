<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Http\Requests\ActRequest;
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->acts->trackFilter();
        $this->acts->applyFilter(new BelongsUserFilter());

        return view('site::act.index', [
            'repository' => $this->acts,
            'acts'       => $this->acts->paginate(config('site.per_page.act', 10), ['acts.*'])
        ]);
    }

    public function show(Act $act)
    {
        $this->authorize('view', $act);

        return view('site::act.show', compact('act'));
    }

    /**
     * @param Act $act
     * @return \Illuminate\Http\Response
     */
    public function edit(Act $act)
    {
        $this->authorize('update', $act);

        return view('site::act.edit', compact('act'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ActRequest $request
     * @param  Act $act
     * @return \Illuminate\Http\Response
     */
    public function update(ActRequest $request, Act $act)
    {
        $act->update($request->input(['act']));

        return redirect()->route('acts.show', $act)->with('success', trans('site::act.updated'));
    }

}