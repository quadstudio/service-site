<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Repositories\OrganizationRepository;
use QuadStudio\Service\Site\Models\Organization;

trait OrganizationControllerTrait
{

    protected $organizations;

    /**
     * Create a new controller instance.
     *
     * @param OrganizationRepository $organizations
     */
    public function __construct(OrganizationRepository $organizations)
    {
        $this->organizations = $organizations;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->organizations->trackFilter();
        return view('site::organization.index', [
            'repository' => $this->organizations,
            'items'      => $this->organizations->paginate(config('site.per_page.organization', 10), [env('DB_PREFIX', '').'organizations.*'])
        ]);
    }

    public function show(Organization $organization)
    {
        return view('site::organization.show', ['organization' => $organization]);
    }
}