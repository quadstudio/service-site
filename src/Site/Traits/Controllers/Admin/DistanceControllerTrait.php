<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Http\Request;
use QuadStudio\Service\Site\Http\Requests\Admin\DistanceRequest;
use QuadStudio\Service\Site\Models\Distance;
use QuadStudio\Service\Site\Repositories\CurrencyRepository;
use QuadStudio\Service\Site\Repositories\DistanceRepository;

trait DistanceControllerTrait
{
    /**
     * @var DistanceRepository
     */
    protected $distances;

    /**
     * Create a new controller instance.
     *
     * @param DistanceRepository $distances
     */
    public function __construct(DistanceRepository $distances)
    {
        $this->distances = $distances;
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->distances->trackFilter();

        return view('site::admin.distance.index', [
            'repository' => $this->distances,
            'distances'  => $this->distances->paginate(config('site.per_page.distance', 10), ['distances.*'])
        ]);
    }

    public function create()
    {
        $sort_order = $this->distances->count();
        return view('site::admin.distance.create', compact('sort_order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DistanceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DistanceRequest $request)
    {

        //dd($request->all());
        $distance = $this->distances->create($request->except(['_token', '_method', '_create']));
        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('admin.distances.create')->with('success', trans('site::distance.created'));
        } else {
            $redirect = redirect()->route('admin.distances.index')->with('success', trans('site::distance.created'));
        }

        return $redirect;
    }


    /**
     * @param Distance $distance
     * @return \Illuminate\Http\Response
     */
    public function edit(Distance $distance)
    {
        return view('site::admin.distance.edit', compact('distance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DistanceRequest $request
     * @param  Distance $distance
     * @return \Illuminate\Http\Response
     */
    public function update(DistanceRequest $request, Distance $distance)
    {

        $distance->update($request->except(['_method', '_token', '_stay']));

        if ($request->input('_stay') == 1) {

            $redirect = redirect()->route('admin.distances.edit', $distance)->with('success', trans('site::distance.updated'));
        } else {
            $redirect = redirect()->route('admin.distances.index')->with('success', trans('site::distance.updated'));
        }

        return $redirect;
    }

    public function sort(Request $request)
    {
        $sort = array_flip($request->input('sort'));

        foreach ($sort as $distance_id => $sort_order) {
            /** @var Distance $distance */
            $distance = Distance::find($distance_id);
            $distance->setAttribute('sort_order', $sort_order);
            $distance->save();
        }
    }

    public function destroy(Request $request, Distance $distance)
    {
        $this->authorize('delete', $distance);

        if ($distance->delete()) {
            $json['remove'][] = '#distance-' . $distance->id;
        } else {
            $json['error'][] = 'error';
        }

        return response()->json($json);
    }


}