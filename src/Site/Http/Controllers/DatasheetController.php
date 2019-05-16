<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Filters\Datasheet\DatasheetActiveFilter;
use QuadStudio\Service\Site\Filters\Datasheet\DatasheetShowFilter;
use QuadStudio\Service\Site\Models\Datasheet;
use QuadStudio\Service\Site\Repositories\DatasheetRepository;

class DatasheetController extends Controller
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
        $this->datasheets->applyFilter(new DatasheetShowFilter());
        $this->datasheets->applyFilter(new DatasheetActiveFilter());

        return view('site::datasheet.index', [
            'repository' => $this->datasheets,
            'datasheets' => $this->datasheets->paginate(config('site.per_page.datasheet', 10), ['datasheets.*'])
        ]);
    }

    public function show(Datasheet $datasheet)
    {
        if (
            $datasheet->getAttribute(config('site.check_field')) === false
            || $datasheet->getAttribute('active') === false
        ) {
            abort(404);
        }
        $products = $datasheet->products()->where('enabled', 1)->orderBy('name')->get();

        return view('site::datasheet.show', compact('datasheet', 'products'));
    }
}