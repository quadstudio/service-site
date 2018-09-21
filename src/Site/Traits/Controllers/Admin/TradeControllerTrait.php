<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Filters\CountryEnabledFilter;
use QuadStudio\Service\Site\Repositories\CountryRepository;
use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Filters\ByNameSortFilter;
use QuadStudio\Service\Site\Http\Requests\TradeRequest;
use QuadStudio\Service\Site\Models\Trade;
use QuadStudio\Service\Site\Repositories\TradeRepository;

trait TradeControllerTrait
{

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->trades->trackFilter();

        return view('site::admin.trade.index', [
            'repository' => $this->trades,
            'trades'      => $this->trades->paginate(config('site.per_page.trade', 10), ['trades.*'])
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
        $this->authorize('create', Trade::class);
        $countries = $this->countries->all();
        $view = $request->ajax() ? 'repair::trade.form' : 'trade.create';
        return view($view, ['countries' => $countries]);
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
        $request->user()->trades()->save(new Trade($request->except(['_token', '_method', '_create'])));

        if ($request->ajax()) {
            $trades = $this->trades
                ->applyFilter(new BelongsUserFilter())
                ->applyFilter(new ByNameSortFilter())
                ->all();
            Session::flash('success', trans('site::trade.created'));
            return response()->json([
                'replace' => [
                    '#form-group-trade_id' => view('repair::repair.field.trade_id')
                        ->with('trades', $trades)->render(),
                ],
            ]);
        }

        if ($request->input('_create') == 1) {
            $redirect = redirect()->route('trades.create')->with('success', trans('site::trade.created'));
        } else {
            $redirect = redirect()->route('trades.index')->with('success', trans('site::trade.created'));
        }

        return $redirect;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Trade $trade
     * @return \Illuminate\Http\Response
     */
    public function edit(Trade $trade)
    {
        $this->authorize('update', $trade);

        $countries = $this->countries->all();

        return view('site::trade.edit', [
            'countries' => $countries,
            'trade'     => $trade
        ]);
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
        $this->authorize('update', $trade);

        $this->trades->update($request->only(['country_id', 'phone']), $trade->id);

        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('trades.edit', $trade)->with('success', trans('site::trade.updated'));
        } else {
            $redirect = redirect()->route('trades.show', $trade)->with('success', trans('site::trade.updated'));
        }

        return $redirect;
    }

    public function show(Trade $trade)
    {
        $this->authorize('view', $trade);

        return view('site::trade.show', ['trade' => $trade]);
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

        if ($this->trades->delete($trade->id) > 0) {
            $redirect = redirect()->route('trades.index')->with('success', trans('site::trade.deleted'));
        } else {
            $redirect = redirect()->route('trades.show', $trade)->with('warning', trans('site::trade.deleted'));
        }

        return $redirect;

    }
}