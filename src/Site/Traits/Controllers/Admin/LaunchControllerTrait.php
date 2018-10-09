<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Filters\CountryEnabledFilter;
use QuadStudio\Service\Site\Http\Requests\LaunchRequest;
use QuadStudio\Service\Site\Models\Launch;
use QuadStudio\Service\Site\Repositories\CountryRepository;
use QuadStudio\Service\Site\Repositories\LaunchRepository;

trait LaunchControllerTrait
{

    protected $launches;
    protected $countries;

    /**
     * Create a new controller instance.
     *
     * @param LaunchRepository $launches
     * @param CountryRepository $countries
     */
    public function __construct(LaunchRepository $launches, CountryRepository $countries)
    {
        $this->launches = $launches;
        $this->countries = $countries;
        $this->countries->trackFilter();
        $this->countries->applyFilter(new CountryEnabledFilter());
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->launches->trackFilter();

        return view('site::admin.launch.index', [
            'repository' => $this->launches,
            'launches'  => $this->launches->paginate(config('site.per_page.launch', 10), ['launches.*'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Launch $launch
     * @return \Illuminate\Http\Response
     */
    public function edit(Launch $launch)
    {
        $countries = $this->countries->all();

        return view('site::admin.launch.edit', [
            'countries' => $countries,
            'launch'  => $launch
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LaunchRequest $request
     * @param  Launch $launch
     * @return \Illuminate\Http\Response
     */
    public function update(LaunchRequest $request, Launch $launch)
    {
        $launch->update($request->except(['_method', '_token', '_stay']));

        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('admin.launches.edit', $launch)->with('success', trans('site::launch.updated'));
        } else {
            $redirect = redirect()->route('admin.launches.show', $launch)->with('success', trans('site::launch.updated'));
        }

        return $redirect;
    }

    public function show(Launch $launch)
    {

        return view('site::admin.launch.show', compact('launch'));
    }

}