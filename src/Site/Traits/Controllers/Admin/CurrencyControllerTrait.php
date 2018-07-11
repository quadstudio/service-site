<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

//use QuadStudio\Service\Site\Models\Currency;
//use QuadStudio\Service\Site\Repositories\CurrencyRepository;

trait CurrencyControllerTrait
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('site::currency.index');
    }
}