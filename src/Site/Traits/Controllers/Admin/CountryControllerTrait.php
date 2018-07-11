<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Repositories\CountryRepository;

trait CountryControllerTrait
{

    protected $countries;

    /**
     * Create a new controller instance.
     *
     * @param CountryRepository $countries
     */
    public function __construct(CountryRepository $countries)
    {
        $this->countries = $countries;
    }

    /**
     * Show the user country
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->countries->trackFilter();
        return view('site::admin.country.index', [
            'repository' => $this->countries,
            'items'      => $this->countries->paginate(config('site.per_page.country', 10), [env('DB_PREFIX', '').'countries.*'])
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param Country $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        return view('site::admin.country.show', ['country' => $country]);
    }
}