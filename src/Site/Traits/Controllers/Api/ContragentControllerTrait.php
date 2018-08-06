<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;

use QuadStudio\Service\Site\Http\Resources\ContragentCollection;
use QuadStudio\Service\Site\Http\Resources\ContragentResource;
use QuadStudio\Service\Site\Models\Contragent;
use QuadStudio\Service\Site\Repositories\ContragentRepository;

trait ContragentControllerTrait
{
    protected $countries;

    /**
     * Create a new controller instance.
     *
     * @param ContragentRepository $countries
     */
    public function __construct(ContragentRepository $countries)
    {
        $this->countries = $countries;
    }

    /**
     * Show the country profile
     *
     * @return ContragentCollection
     */
    public function index()
    {
        return new ContragentCollection(
            $this
                ->countries
                ->all()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Contragent $contragent
     * @return ContragentResource
     */
    public function show(Contragent $contragent)
    {
        return new ContragentResource($contragent);
    }
}