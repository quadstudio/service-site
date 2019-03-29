<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Filters\ByNameSortFilter;
use QuadStudio\Service\Site\Filters\CountryEnabledFilter;
use QuadStudio\Service\Site\Http\Requests\TradeRequest;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Trade;
use QuadStudio\Service\Site\Repositories\CountryRepository;
use QuadStudio\Service\Site\Repositories\TradeRepository;

class TradeController extends Controller
{

    use AuthorizesRequests;

    protected $trades;
    protected $countries;

    /**
     * Create a new controller instance.
     *
     * @param TradeRepository $trades
     * @param CountryRepository $countries
     */
    public function __construct(TradeRepository $trades, CountryRepository $countries)
    {
        $this->trades = $trades;
        $this->countries = $countries;
        $this->countries->trackFilter();
        $this->countries->applyFilter(new CountryEnabledFilter());
    }

    /**
     * Show the user profile
     *
     * @param TradeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(TradeRequest $request)
    {

        $trades = $request->user()->trades()->orderBy('name')->get();

        return view('site::trade.index', compact('trades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param TradeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(TradeRequest $request)
    {
        $trade = new Trade();
        $this->authorize('create', Trade::class);
        $countries = Country::query()->where('enabled', 1)->orderBy('name')->get();
        $view = $request->ajax() ? 'site::trade.form.create' : 'site::trade.create';

        return view($view, compact('countries', 'trade'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TradeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TradeRequest $request)
    {
        $this->authorize('create', Trade::class);
        $request->user()->trades()->save($trade = new Trade($request->input('trade')));

        if ($request->ajax()) {

            $trades = $this->trades
                ->applyFilter(new BelongsUserFilter())
                ->applyFilter(new ByNameSortFilter())
                ->all();
            Session::flash('success', trans('site::trade.created'));

            return response()->json([
                'update' => [
                    '#trade_id' => view('site::trade.options')
                        ->with('trades', $trades)
                        ->with('trade_id', $trade->getKey())
                        ->render()
                ],
                'append' => [
                    '#toasts' => view('site::components.toast')
                        ->with('message', trans('site::trade.created'))
                        ->with('status', 'success')
                        ->render()
                ]
            ]);
        }

        return redirect()->route('trades.index')->with('success', trans('site::trade.created'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TradeRequest $request
     * @param  Trade $trade
     * @return \Illuminate\Http\Response
     */
    public function edit(TradeRequest $request, Trade $trade)
    {
        $this->authorize('edit', $trade);
        $countries = Country::query()->where('enabled', 1)->orderBy('name')->get();
        $view = $request->ajax() ? 'site::trade.form.edit' : 'site::trade.edit';

        return view($view, compact('countries', 'trade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TradeRequest $request
     * @param  Trade $trade
     * @return \Illuminate\Http\Response
     */
    public function update(TradeRequest $request, Trade $trade)
    {
        $this->authorize('edit', $trade);
        $trade->update($request->input('trade'));

        return redirect()->route('trades.index')->with('success', trans('site::trade.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Trade $trade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trade $trade)
    {
        $this->authorize('delete', $trade);

        if ($trade->delete()) {
            $json['remove'][] = '#trade-' . $trade->id;
        } else {
            $json['error'][] = 'error';
        }

        return response()->json($json);

    }
}