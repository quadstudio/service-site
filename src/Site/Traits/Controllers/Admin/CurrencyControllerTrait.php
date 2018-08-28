<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Contracts\Exchange;
use QuadStudio\Service\Site\Models\Currency;
use QuadStudio\Service\Site\Repositories\CurrencyRepository;

trait CurrencyControllerTrait
{
    /**
     * @var CurrencyRepository
     */
    private $currencies;

    /**
     * Create a new controller instance.
     * @param CurrencyRepository $currencies
     */
    public function __construct(CurrencyRepository $currencies)
    {

        $this->currencies = $currencies;
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = $this->currencies->paginate(config('site.per_page.currency', 10), [env('DB_PREFIX', '') . 'currencies.*']);

        return view('site::admin.currency.index', compact('currencies'));
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        return view('site::admin.currency.show', compact('currency'));
    }

    public function refresh(Exchange $exchange)
    {
        foreach (config('site.update', []) as $update_id) {
            $currency = $this->currencies->find($update_id);
            $currency->fill($exchange->get($update_id));
            $currency->save();
        }
        if(Auth::user()->admin == 1){
            return redirect()->route('admin.currencies.index')->with('success', trans('site::currency.updated'));
        }
        return null;

    }
}