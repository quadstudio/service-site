<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Repositories\CurrencyArchiveRepository;

trait CurrencyArchiveControllerTrait
{
    /**
     * @var CurrencyArchiveRepository
     */
    private $archives;

    /**
     * Create a new controller instance.
     * @param CurrencyArchiveRepository $archives
     */
    public function __construct(CurrencyArchiveRepository $archives)
    {

        $this->archives = $archives;
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->archives->trackFilter();
        $repository = $this->archives;
        $archives = $this->archives->paginate(config('site.per_page.archive', 10), ['currency_archives.*']);

        return view('site::admin.archive.index', compact('archives', 'repository'));
    }

}