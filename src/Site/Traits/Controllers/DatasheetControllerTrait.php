<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\ActiveFilter;
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

        $this->datasheets->trackFilter();
        $this->datasheets->applyFilter(new ActiveFilter());
        return view('site::datasheet.index', [
            'repository' => $this->datasheets,
            'datasheets'      => $this->datasheets->paginate(config('site.per_page.datasheet', 10), [env('DB_PREFIX', '').'datasheets.*'])
        ]);
    }

    public function show(Datasheet $datasheet)
    {
        return view('site::datasheet.show', ['datasheet' => $datasheet]);
    }
}