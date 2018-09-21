<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

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
        $currencies = $this->currencies->paginate(config('site.per_page.currency', 10), ['currencies.*']);

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

}