<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Repositories\ContragentRepository;

trait ContragentControllerTrait
{

    protected $contragents;

    /**
     * Create a new controller instance.
     *
     * @param ContragentRepository $contragents
     */
    public function __construct(ContragentRepository $contragents)
    {
        $this->contragents = $contragents;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->contragents->trackFilter();
        $this->contragents->applyFilter(new BelongsUserFilter());
        return view('site::contragent.index', [
            'repository' => $this->contragents,
            'contragents'      => $this->contragents->paginate(config('site.per_page.contragent', 10), [env('DB_PREFIX', '') . 'contragents.*'])
        ]);
    }

}