<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Http\Requests\ContragentRequest;
use QuadStudio\Service\Site\Models\Contragent;
use QuadStudio\Service\Site\Repositories\ContragentRepository;
use QuadStudio\Service\Site\Repositories\ContragentTypeRepository;
use QuadStudio\Service\Site\Repositories\OrganizationRepository;

trait ContragentControllerTrait
{
    /**
     * @var ContragentRepository
     */
    protected $contragents;
    /**
     * @var ContragentTypeRepository
     */
    protected $types;
    /**
     * @var OrganizationRepository
     */
    private $organizations;

    /**
     * Create a new controller instance.
     *
     * @param ContragentRepository $contragents
     * @param ContragentTypeRepository $types
     * @param OrganizationRepository $organizations
     */
    public function __construct(
        ContragentRepository $contragents,
        ContragentTypeRepository $types,
        OrganizationRepository $organizations
    )
    {
        $this->contragents = $contragents;
        $this->types = $types;
        $this->organizations = $organizations;
    }

    /**
     * Show the user contragent
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->contragents->trackFilter();

        return view('site::admin.contragent.index', [
            'repository'  => $this->contragents,
            'contragents' => $this->contragents->paginate(config('site.per_page.contragent', 10), [env('DB_PREFIX', '') . 'contragents.*'])
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param Contragent $contragent
     * @return \Illuminate\Http\Response
     */
    public function show(Contragent $contragent)
    {
        return view('site::admin.contragent.show', ['contragent' => $contragent]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Contragent $contragent
     * @return \Illuminate\Http\Response
     */
    public function edit(Contragent $contragent)
    {
        $types = $this->types->all();
        $organizations = $this->organizations->all();

        return view('site::admin.contragent.edit', compact('contragent', 'types', 'organizations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ContragentRequest $request
     * @param  Contragent $contragent
     * @return \Illuminate\Http\Response
     */
    public function update(ContragentRequest $request, Contragent $contragent)
    {
        $contragent->update($request->input('contragent'));

        return redirect()->route('admin.contragents.show', $contragent)->with('success', trans('site::contragent.updated'));
    }
}