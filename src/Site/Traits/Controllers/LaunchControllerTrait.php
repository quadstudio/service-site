<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Filters\ByNameSortFilter;
use QuadStudio\Service\Site\Filters\CountryEnabledFilter;
use QuadStudio\Service\Site\Http\Requests\LaunchRequest;
use QuadStudio\Service\Site\Http\Requests\TradeRequest;
use QuadStudio\Service\Site\Models\Launch;
use QuadStudio\Service\Site\Repositories\CountryRepository;
use QuadStudio\Service\Site\Repositories\LaunchRepository;

trait LaunchControllerTrait
{

    protected $launches;
    protected $countries;

    /**
     * Create a new controller instance.
     *
     * @param LaunchRepository $launches
     * @param CountryRepository $countries
     */
    public function __construct(LaunchRepository $launches, CountryRepository $countries)
    {
        $this->launches = $launches;
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
        $this->authorize('index', Launch::class);
        $this->launches->trackFilter();
        $this->launches->applyFilter(new BelongsUserFilter());

        return view('site::launch.index', [
            'repository' => $this->launches,
            'launches'   => $this->launches->paginate(config('site.per_page.launch', 10), ['launches.*'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param TradeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(TradeRequest $request)
    {
        $this->authorize('create', Launch::class);
        $countries = $this->countries->all();
        $view = $request->ajax() ? 'site::launch.form' : 'site::launch.create';

        return view($view, ['countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LaunchRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LaunchRequest $request)
    {
        $this->authorize('create', Launch::class);
        $request->user()->launches()->save($launch = new Launch($request->except(['_token', '_method', '_create'])));

        if ($request->ajax()) {
            $launches = $this->launches
                ->applyFilter(new BelongsUserFilter())
                ->applyFilter(new ByNameSortFilter())
                ->all();
            Session::flash('success', trans('site::launch.created'));

            return response()->json([
                'replace' => [
                    '#form-group-launch_id' => view('site::repair.create.launch_id')
                        ->with('launches', $launches)
                        ->with('selected', $launch->getKey())
                        ->render(),
                ],
            ]);
        }

        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('launches.create')->with('success', trans('site::launch.created'));
        } else {
            $redirect = redirect()->route('launches.index')->with('success', trans('site::launch.created'));
        }

        return $redirect;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Launch $launch
     * @return \Illuminate\Http\Response
     */
    public function edit(Launch $launch)
    {
        $this->authorize('update', $launch);

        $countries = $this->countries->all();

        return view('site::launch.edit', [
            'countries' => $countries,
            'launch'    => $launch
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LaunchRequest $request
     * @param  Launch $launch
     * @return \Illuminate\Http\Response
     */
    public function update(LaunchRequest $request, Launch $launch)
    {
        $this->authorize('update', $launch);

        $this->launches->update($request->only([
            'country_id',
            'phone',
            'document_name',
            'document_number',
            'document_date',
            'document_who'
        ]), $launch->id);

        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('launches.edit', $launch)->with('success', trans('site::launch.updated'));
        } else {
            $redirect = redirect()->route('launches.show', $launch)->with('success', trans('site::launch.updated'));
        }

        return $redirect;
    }

    public function show(Launch $launch)
    {
        $this->authorize('view', $launch);

        return view('site::launch.show', ['launch' => $launch]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Launch $launch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Launch $launch)
    {
        $this->authorize('delete', $launch);

        if ($this->launches->delete($launch->id) > 0) {
            $redirect = redirect()->route('launches.index')->with('success', trans('site::launch.deleted'));
        } else {
            $redirect = redirect()->route('launches.show', $launch)->with('warning', trans('site::launch.deleted'));
        }

        return $redirect;

    }
}