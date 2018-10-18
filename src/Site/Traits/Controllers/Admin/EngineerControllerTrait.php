<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Filters\CountryEnabledFilter;
use QuadStudio\Service\Site\Http\Requests\EngineerRequest;
use QuadStudio\Service\Site\Models\Engineer;
use QuadStudio\Service\Site\Repositories\CountryRepository;
use QuadStudio\Service\Site\Repositories\EngineerRepository;

trait EngineerControllerTrait
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->engineers->trackFilter();

        return view('site::admin.engineer.index', [
            'repository' => $this->engineers,
            'engineers'  => $this->engineers->paginate(config('site.per_page.engineer', 10), ['engineers.*'])
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
        $countries = $this->countries->all();

        return view('site::admin.engineer.edit', [
            'countries' => $countries,
            'engineer'  => $engineer
        ]);
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
        $engineer->update($request->except(['_method', '_token', '_stay']));

        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('admin.engineers.edit', $engineer)->with('success', trans('site::engineer.updated'));
        } else {
            $redirect = redirect()->route('admin.engineers.show', $engineer)->with('success', trans('site::engineer.updated'));
        }

        return $redirect;
    }

    public function show(Engineer $engineer)
    {

        return view('site::admin.engineer.show', compact('engineer'));
    }

}