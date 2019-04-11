<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\CountryEnabledFilter;
use QuadStudio\Service\Site\Filters\Engineer\EngineerPerPageFilter;
use QuadStudio\Service\Site\Filters\Engineer\EngineerUserFilter;
use QuadStudio\Service\Site\Http\Requests\EngineerRequest;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Engineer;
use QuadStudio\Service\Site\Repositories\CountryRepository;
use QuadStudio\Service\Site\Repositories\EngineerRepository;

class EngineerController extends Controller
{

    protected $engineers;
    protected $countries;

    /**
     * Create a new controller instance.
     *
     * @param EngineerRepository $engineers
     * @param CountryRepository $countries
     */
    public function __construct(EngineerRepository $engineers, CountryRepository $countries)
    {
        $this->engineers = $engineers;
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

        $this->engineers->trackFilter();
        $this->engineers->pushTrackFilter(EngineerUserFilter::class);
        $this->engineers->pushTrackFilter(EngineerPerPageFilter::class);
        return view('site::admin.engineer.index', [
            'repository' => $this->engineers,
            'engineers'  => $this->engineers->paginate($request->input('filter.per_page', config('site.per_page.engineer', 10)), ['engineers.*'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Engineer $engineer
     * @return \Illuminate\Http\Response
     */
    public function edit(Engineer $engineer)
    {
        $countries = Country::query()->where('enabled', 1)->orderBy('name')->get();

        return view('site::admin.engineer.edit', compact('engineer', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EngineerRequest $request
     * @param  Engineer $engineer
     * @return \Illuminate\Http\Response
     */
    public function update(EngineerRequest $request, Engineer $engineer)
    {
        $engineer->update($request->input('engineer'));

        return redirect()->route('admin.engineers.index', ['filter[user]='.$engineer->getAttribute('user_id')])->with('success', trans('site::engineer.updated'));
    }

}