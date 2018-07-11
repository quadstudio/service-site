<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Repositories\BankRepository;
use QuadStudio\Service\Site\Models\Bank;

trait BankControllerTrait
{

    protected $banks;

    /**
     * Create a new controller instance.
     *
     * @param BankRepository $banks
     */
    public function __construct(BankRepository $banks)
    {
        $this->banks = $banks;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->banks->trackFilter();
        return view('site::bank.index', [
            'repository' => $this->banks,
            'items'      => $this->banks->paginate(config('site.per_page.bank', 10), [env('DB_PREFIX', '').'banks.*'])
        ]);
    }

    public function show(Bank $bank)
    {
        return view('site::bank.show', ['bank' => $bank]);
    }
}