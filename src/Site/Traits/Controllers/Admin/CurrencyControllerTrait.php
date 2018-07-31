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
        $currencies = $this->currencies->all();
        return view('site::admin.currency.index', compact('currencies'));
    }
}