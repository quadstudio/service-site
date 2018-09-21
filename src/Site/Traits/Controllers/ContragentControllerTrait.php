<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Http\Requests\ContragentRequest;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\Contragent;
use QuadStudio\Service\Site\Models\ContragentType;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Repositories\ContragentRepository;

trait ContragentControllerTrait
{

    protected $contragents;

    /**
     * Create a new controller instance.
     *
     * @param ContragentRepository $contragents
     */
    public function __construct(ContragentRepository $contragents)
    {
        $this->contragents = $contragents;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Contragent::class);
        $this->contragents->trackFilter();
        $this->contragents->applyFilter(new BelongsUserFilter());

        return view('site::contragent.index', [
            'repository'  => $this->contragents,
            'contragents' => $this->contragents->paginate(config('site.per_page.contragent', 10), ['contragents.*'])
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Contragent::class);
        $address_legal_regions = $address_postal_regions = collect([]);
        $countries = Country::enabled()->orderBy('sort_order')->get();
        if (old('address.legal.country_id', false)) {
            $address_legal_regions = Region::where('country_id', old('address.legal.country_id'))->orderBy('name')->get();
        }
        if (old('address.postal.country_id', false)) {
            $address_postal_regions = Region::where('country_id', old('address.postal.country_id'))->orderBy('name')->get();
        }
        $types = ContragentType::all();

        return view('site::contragent.create', compact('countries', 'types', 'address_legal_regions', 'address_postal_regions'));
    }

    /**
     * @param ContragentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContragentRequest $request)
    {

        /** @var Contragent $contragent */
        $request->user()->contragents()->save($contragent = Contragent::create($request->input('contragent')));
        $contragent->addresses()->saveMany([
            Address::create($request->input('address.legal')),
            Address::create($request->input('address.postal')),
        ]);
        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('contragents.create')->with('success', trans('site::contragent.created'));
        } else {
            $redirect = redirect()->route('contragents.index')->with('success', trans('site::contragent.created'));
        }

        return $redirect;
    }

    /**
     * @param Contragent $contragent
     * @return \Illuminate\Http\Response
     */
    public function edit(Contragent $contragent)
    {
        $this->authorize('edit', $contragent);
        $types = ContragentType::all();

        return view('site::contragent.edit', compact('contragent', 'types'));
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

        return redirect()->route('contragents.show', $contragent)->with('success', trans('site::contragent.updated'));
    }

    /**
     * @param Contragent $contragent
     * @return \Illuminate\Http\Response
     */
    public function show(Contragent $contragent)
    {
        return view('site::contragent.show', compact('contragent'));
    }

}