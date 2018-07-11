<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Repositories\DatasheetRepository;
use QuadStudio\Service\Site\Models\Datasheet;

trait DatasheetControllerTrait
{

    protected $datasheets;

    /**
     * Create a new controller instance.
     *
     * @param DatasheetRepository $datasheets
     */
    public function __construct(DatasheetRepository $datasheets)
    {
        $this->datasheets = $datasheets;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('site::datasheet.index');
//        $this->datasheets->trackFilter();
//        return view('site::datasheet.index', [
//            'repository' => $this->datasheets,
//            'items'      => $this->datasheets->paginate(config('site.per_page.datasheet', 10), [env('DB_PREFIX', '').'datasheets.*'])
//        ]);
    }

    public function show(Datasheet $datasheet)
    {
        return view('site::datasheet.show', ['datasheet' => $datasheet]);
    }
}