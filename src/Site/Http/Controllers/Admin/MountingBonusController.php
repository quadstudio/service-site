<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Filters\MountingBonus\MountingBonusPerPageFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\MountingBonusRequest;
use QuadStudio\Service\Site\Models\MountingBonus;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Repositories\MountingBonusRepository;

class MountingBonusController extends Controller
{
    /**
     * @var MountingBonusRepository
     */
    protected $mounting_bonuses;

    /**
     * Create a new controller instance.
     *
     * @param MountingBonusRepository $mounting_bonuses
     */
    public function __construct(MountingBonusRepository $mounting_bonuses)
    {
        $this->mounting_bonuses = $mounting_bonuses;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index(MountingBonusRequest $request)
    {
        $this->mounting_bonuses->trackFilter();
        $this->mounting_bonuses->pushTrackFilter(MountingBonusPerPageFilter::class);

        return view('site::admin.mounting_bonus.index', [
            'repository'       => $this->mounting_bonuses,
            'mounting_bonuses' => $this->mounting_bonuses->paginate($request->input('filter.per_page', config('site.per_page.mounting_bonus', 10)), ['mounting_bonuses.*'])
        ]);
    }

    /**
     * @param MountingBonusRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(MountingBonusRequest $request)
    {
        $products = Product::query()
            ->mounted()
            ->orderBy('name')
            ->whereDoesntHave('mounting_bonus')
            ->get();
        $selected_product = Product::query()->findOrNew($request->input('product_id'));
        return view('site::admin.mounting_bonus.create', compact(
            'authorization_brands',
            'products',
            'selected_product'
        ));
    }

    /**
     * @param  MountingBonusRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MountingBonusRequest $request)
    {
        $mounting_bonus = $this->mounting_bonuses->create($request->input(['mounting_bonus']));

        return redirect()->route('admin.products.show', $mounting_bonus->product)->with('success', trans('site::mounting_bonus.created'));
    }

    /**
     * @param MountingBonus $mounting_bonus
     * @return \Illuminate\Http\Response
     */
    public function edit(MountingBonus $mounting_bonus)
    {
        return view('site::admin.mounting_bonus.edit', compact('mounting_bonus'));
    }

    /**
     * @param  MountingBonusRequest $request
     * @param  MountingBonus $mounting_bonus
     * @return \Illuminate\Http\Response
     */
    public function update(MountingBonusRequest $request, MountingBonus $mounting_bonus)
    {

        $mounting_bonus->update($request->input(['mounting_bonus']));

        return redirect()->route('admin.products.show', $mounting_bonus->product)->with('success', trans('site::mounting_bonus.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  MountingBonus $mounting_bonus
     * @return \Illuminate\Http\Response
     */
    public function destroy( MountingBonus $mounting_bonus)
    {
        if ($mounting_bonus->delete()) {
            Session::flash('success', trans('site::mounting_bonus.deleted'));
        } else {
            Session::flash('error', trans('site::mounting_bonus.error.deleted'));
        }
        $json['redirect'] = route('admin.products.show', $mounting_bonus->product);

        return response()->json($json);
    }

}