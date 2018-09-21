<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use Auth;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Filters\ByNameSortFilter;
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
        $this->authorize('index', Engineer::class);
        $this->engineers->applyFilter(new BelongsUserFilter());
        $this->engineers->trackFilter();

        return view('site::engineer.index', [
            'repository' => $this->engineers,
            'engineers'  => $this->engineers->paginate(config('site.per_page.engineer', 10), ['engineers.*'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param EngineerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(EngineerRequest $request)
    {
        $this->authorize('create', Engineer::class);
        $countries = $this->countries->all();
        $view = $request->ajax() ? 'site::engineer.form' : 'site::engineer.create';

        return view($view, ['countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EngineerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EngineerRequest $request)
    {
        $this->authorize('create', Engineer::class);

        $request->user()->engineers()->save(new Engineer($request->except(['_token', '_method', '_create'])));

        if ($request->ajax()) {
            $engineers = $this->engineers
                ->applyFilter(new BelongsUserFilter())
                ->applyFilter(new ByNameSortFilter())
                ->all();
            Session::flash('success', trans('site::engineer.created'));

            return response()->json([
                'replace' => [
                    '#form-group-engineer_id' => view('site::repair.create.engineer_id')
                        ->with('engineers', $engineers)->render(),
                ],
            ]);
        }

        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('engineers.create')->with('success', trans('site::engineer.created'));
        } else {
            $redirect = redirect()->route('engineers.index')->with('success', trans('site::engineer.created'));
        }

        return $redirect;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Engineer $engineer
     * @return \Illuminate\Http\Response
     */
    public function edit(Engineer $engineer)
    {
        $this->authorize('update', $engineer);
        $countries = $this->countries->all();

        return view('site::engineer.edit', [
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
        $this->authorize('update', $engineer);
        $this->engineers->update($request->only(['country_id', 'phone']), $engineer->id);

        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('engineers.edit', $engineer)->with('success', trans('site::engineer.updated'));
        } else {
            $redirect = redirect()->route('engineers.show', $engineer)->with('success', trans('site::engineer.updated'));
        }

        return $redirect;
    }

    public function show(Engineer $engineer)
    {
        $this->authorize('view', $engineer);

        return view('site::engineer.show', ['engineer' => $engineer]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Engineer $engineer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Engineer $engineer)
    {
        $this->authorize('delete', $engineer);

        if ($this->engineers->delete($engineer->id) > 0) {
            $redirect = redirect()->route('engineers.index')->with('success', trans('site::engineer.deleted'));
        } else {
            $redirect = redirect()->route('engineers.show', $engineer)->with('warning', trans('site::engineer.deleted'));
        }

        return $redirect;

    }
}