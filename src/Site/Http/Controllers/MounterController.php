<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Events\MounterCreateEvent;
use QuadStudio\Service\Site\Filters\Mounter\MounterBelongsUserFilter;
use QuadStudio\Service\Site\Filters\Mounter\MounterPerPageFilter;
use QuadStudio\Service\Site\Http\Requests\MounterRequest;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Equipment;
use QuadStudio\Service\Site\Models\Mounter;
use QuadStudio\Service\Site\Models\MounterStatus;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Repositories\MounterRepository;


class MounterController extends Controller
{

    use AuthorizesRequests;
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
     * @param MounterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(MounterRequest $request)
    {

        $this->mounters->trackFilter();
        $this->mounters->applyFilter(new MounterBelongsUserFilter());
        $this->mounters->pushTrackFilter(MounterPerPageFilter::class);

        return view('site::mounter.index', [
            'repository' => $this->mounters,
            'mounters'   => $this->mounters->paginate($request->input('filter.per_page', config('site.per_page.mounter', 10)), ['mounters.*'])
        ]);
    }

    /**
     * @param Address $address
     * @return \Illuminate\Http\Response
     */
    public function create(Address $address)
    {

        $countries = Country::query()->where('enabled', 1)->orderBy('name')->get();

        $equipments = Equipment::query()
            ->where(config('site.check_field'), 1)
            ->where('enabled', 1)
            ->where('mounter_enabled', 1)
            ->whereHas('products', function ($product) {
                $product
                    ->where(config('site.check_field'), 1)
                    ->where('enabled', 1);
            })
            ->whereHas('catalog', function ($catalog) {
                $catalog
                    ->where(config('site.check_field'), 1)
                    ->where('enabled', 1)
                    ->where('mounter_enabled', 1);
            })
            ->orderBy('name')
            ->get();
        $products = collect([]);

        if(old('mounter.equipment_id')){
            $products = Product::query()
                ->where('equipment_id', old('mounter.equipment_id'))
                ->mounter()
                ->get();
        }

        return view('site::mounter.create', compact(
            'countries',
            'equipments',
            'products',
            'address'
        ));
    }

    /**
     * @param  MounterRequest $request
     * @param Address $address
     * @return \Illuminate\Http\Response
     */
    public function store(MounterRequest $request, Address $address)
    {
        /** @var Mounter $mounter */
        $mounter = $address->mounters()->create($request->input('mounter'));

        event(new MounterCreateEvent($mounter));

        return redirect()->route('mounter-requests')->with('success', trans('site::mounter.created'));
    }

    /**
     * @param Mounter $mounter
     * @return \Illuminate\Http\Response
     */
    public function show(Mounter $mounter)
    {

        $this->authorize('view', $mounter);

        return view('site::mounter.show', compact('mounter'));
    }

    /**
     * @param Mounter $mounter
     * @return \Illuminate\Http\Response
     */
    public function edit(Mounter $mounter)
    {

        $this->authorize('edit', $mounter);

        $mounter_statuses = MounterStatus::query()->orderBy('sort_order')->get();

        return view('site::mounter.edit', compact('mounter', 'mounter_statuses'));
    }

    /**
     * @param  MounterRequest $request
     * @param  Mounter $mounter
     * @return \Illuminate\Http\Response
     */
    public function update(MounterRequest $request, Mounter $mounter)
    {
        $mounter->update($request->input('mounter'));

        return redirect()->route('mounters.show', $mounter)->with('success', trans('site::mounter.updated'));
    }

}
