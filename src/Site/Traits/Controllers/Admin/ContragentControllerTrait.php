<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Http\Requests\ContragentRequest;
use QuadStudio\Service\Site\Models\Contragent;
use QuadStudio\Service\Site\Repositories\ContragentRepository;
use QuadStudio\Service\Site\Repositories\ContragentTypeRepository;

trait ContragentControllerTrait
{

    protected $contragents;
    protected $types;

    /**
     * Create a new controller instance.
     *
     * @param ContragentRepository $contragents
     * @param ContragentTypeRepository $types
     */
    public function __construct(ContragentRepository $contragents, ContragentTypeRepository $types)
    {
        $this->contragents = $contragents;
        $this->types = $types;
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
            'repository' => $this->contragents,
            'items'      => $this->contragents->paginate(config('site.per_page.contragent', 10), [env('DB_PREFIX', '').'contragents.*'])
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
        return view('site::admin.contragent.edit', compact('contragent', 'types'));
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
        $this->contragents->update($request->input('contragent'), $contragent->id);
        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('admin.contragents.edit', $contragent)->with('success', trans('site::contragent.updated'));
        } else {
            $redirect = redirect()->route('admin.contragents.show', $contragent)->with('success', trans('site::contragent.updated'));
        }

        return $redirect;
    }
}