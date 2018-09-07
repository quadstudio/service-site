<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\Datasheet\ActiveFilter;
use QuadStudio\Service\Site\Models\Datasheet;
use QuadStudio\Service\Site\Repositories\DatasheetRepository;

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
            'datasheets' => $this->datasheets->paginate(config('site.per_page.datasheet', 10), [env('DB_PREFIX', '') . 'datasheets.*'])
        ]);
    }

    public function show(Datasheet $datasheet)
    {
        if($datasheet->active == 0){
            abort(404);
        }
        $products = $datasheet->products()->where('enabled', 1)->orderBy('name')->get();
        return view('site::datasheet.show', compact('datasheet', 'products'));
    }
}