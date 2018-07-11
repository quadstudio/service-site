<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;

use QuadStudio\Service\Site\Filters\CountryEnabledFilter;
use QuadStudio\Service\Site\Filters\CountrySortFilter;
use QuadStudio\Service\Site\Http\Resources\CountryCollection;
use QuadStudio\Service\Site\Http\Resources\CountryWithPhoneResource;
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
     * Show the country profile
     *
     * @return CountryCollection
     */
    public function index()
    {
        return new CountryCollection(
            $this
                ->countries
                ->applyFilter(new CountryEnabledFilter())
                ->applyFilter(new CountrySortFilter())
                ->all()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Country $country
     * @return CountryWithPhoneResource
     */
    public function show(Country $country)
    {
        return new CountryWithPhoneResource($country);
    }
}