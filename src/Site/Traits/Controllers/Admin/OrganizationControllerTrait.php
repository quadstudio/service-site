<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Http\Requests\Admin\OrganizationRequest;
use QuadStudio\Service\Site\Models\Organization;
use QuadStudio\Service\Site\Repositories\OrganizationRepository;

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

        return view('site::admin.organization.index', [
            'repository'    => $this->organizations,
            'organizations' => $this->organizations->paginate(config('site.per_page.organization', 10), [env('DB_PREFIX', '') . 'organizations.*'])
        ]);
    }

    public function show(Organization $organization)
    {
        return view('site::admin.organization.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        $accounts = $organization->accounts()->get();

        return view('site::admin.organization.edit', compact('organization', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OrganizationRequest $request
     * @param  Organization $organization
     * @return \Illuminate\Http\Response
     */
    public function update(OrganizationRequest $request, Organization $organization)
    {
        $organization->update($request->only(['account_id']));

        return redirect()->route('admin.organizations.show', $organization)->with('success', trans('site::organization.updated'));
    }
}