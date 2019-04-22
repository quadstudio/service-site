<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Concerns\StoreMessages;
use QuadStudio\Service\Site\Filters\Mounter\MounterPerPageFilter;
use QuadStudio\Service\Site\Filters\Mounter\MounterRegionFilter;
use QuadStudio\Service\Site\Filters\Mounter\MounterStatusFilter;
use QuadStudio\Service\Site\Filters\Mounter\MounterUserFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\MounterRequest;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Mounter;
use QuadStudio\Service\Site\Models\MounterStatus;
use QuadStudio\Service\Site\Repositories\MounterRepository;

class MounterController extends Controller
{

    use StoreMessages;

    /**
     * @var MounterRepository
     */
    private $mounters;

    /**
     * MounterController constructor.
     * @param MounterRepository $mounters
     */
    public function __construct(MounterRepository $mounters)
    {

        $this->mounters = $mounters;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->mounters->trackFilter();

        $this->mounters->pushTrackFilter(MounterStatusFilter::class);
        $this->mounters->pushTrackFilter(MounterRegionFilter::class);
        $this->mounters->pushTrackFilter(MounterUserFilter::class);
        $this->mounters->pushTrackFilter(MounterPerPageFilter::class);
        $mounters = $this->mounters->paginate($request->input('filter.per_page', config('site.per_page.mounter', 10)), ['mounters.*']);
        $repository = $this->mounters;

        return view('site::admin.mounter.index', compact('mounters', 'repository'));
    }

    /**
     * @param Mounter $mounter
     * @return \Illuminate\Http\Response
     */
    public function show(Mounter $mounter)
    {

        return view('site::admin.mounter.show', compact(
            'mounter'
        ));
    }


    /**
     * @param Mounter $mounter
     * @return \Illuminate\Http\Response
     */
    public function edit(Mounter $mounter)
    {
        $countries = Country::query()->where('enabled', 1)->orderBy('name')->get();
        $mounter_statuses = MounterStatus::query()->orderBy('sort_order')->get();

        return view('site::admin.mounter.edit', compact('mounter', 'countries', 'mounter_statuses'));
    }

    /**
     * @param  MounterRequest $request
     * @param  Mounter $mounter
     * @return \Illuminate\Http\Response
     */
    public function update(MounterRequest $request, Mounter $mounter)
    {
        $mounter->update($request->input('mounter'));

        return redirect()->route('admin.mounters.show', $mounter)->with('success', trans('site::mounter.updated'));
    }


}