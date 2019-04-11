<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\CountryEnabledFilter;
use QuadStudio\Service\Site\Filters\Launch\LaunchPerPageFilter;
use QuadStudio\Service\Site\Filters\Launch\LaunchUserFilter;
use QuadStudio\Service\Site\Http\Requests\LaunchRequest;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Launch;
use QuadStudio\Service\Site\Repositories\CountryRepository;
use QuadStudio\Service\Site\Repositories\LaunchRepository;

class LaunchController extends Controller
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->launches->trackFilter();
        $this->launches->pushTrackFilter(LaunchUserFilter::class);
        $this->launches->pushTrackFilter(LaunchPerPageFilter::class);
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
        $countries = Country::query()->where('enabled', 1)->orderBy('name')->get();

        return view('site::admin.launch.edit', compact('launch', 'countries'));
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
        $launch->update($request->input('launch'));

        return redirect()->route('admin.launches.index', ['filter[user]='.$launch->getAttribute('user_id')])->with('success', trans('site::launch.updated'));
    }

}