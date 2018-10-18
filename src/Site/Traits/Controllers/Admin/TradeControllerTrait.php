<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Filters\CountryEnabledFilter;
use QuadStudio\Service\Site\Http\Requests\TradeRequest;
use QuadStudio\Service\Site\Models\Trade;
use QuadStudio\Service\Site\Repositories\CountryRepository;
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
            'trades'  => $this->trades->paginate(config('site.per_page.trade', 10), ['trades.*'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Trade $trade
     * @return \Illuminate\Http\Response
     */
    public function edit(Trade $trade)
    {
        $countries = $this->countries->all();

        return view('site::admin.trade.edit', [
            'countries' => $countries,
            'trade'  => $trade
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
        $trade->update($request->except(['_token', '_method', '_stay']));

        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('admin.trades.edit', $trade)->with('success', trans('site::trade.updated'));
        } else {
            $redirect = redirect()->route('admin.trades.show', $trade)->with('success', trans('site::trade.updated'));
        }

        return $redirect;
    }

    public function show(Trade $trade)
    {

        return view('site::admin.trade.show', compact('trade'));
    }

}