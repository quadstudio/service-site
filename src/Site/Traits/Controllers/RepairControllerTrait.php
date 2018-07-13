<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Models\Repair;
use QuadStudio\Service\Site\Models\File;
use QuadStudio\Service\Site\Repositories\CountryRepository;
use QuadStudio\Service\Site\Repositories\RepairRepository;
use QuadStudio\Service\Site\Repositories\EngineerRepository;
use QuadStudio\Service\Site\Repositories\FileRepository;
use QuadStudio\Service\Site\Repositories\FileTypeRepository;
use QuadStudio\Service\Site\Repositories\LaunchRepository;
use QuadStudio\Service\Site\Repositories\TradeRepository;
use QuadStudio\Service\Site\Filters\CountryEnabledFilter;
use QuadStudio\Service\Site\Filters\CountrySortFilter;
use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Filters\ByNameSortFilter;
use QuadStudio\Service\Site\Http\Requests\RepairRequest;

trait RepairControllerTrait
{
    /**
     * @var RepairRepository
     */
    protected $repairs;
    /**
     * @var EngineerRepository
     */
    protected $engineers;
    /**
     * @var LaunchRepository
     */
    protected $launches;
    /**
     * @var TradeRepository
     */
    protected $trades;
    /**
     * @var FileTypeRepository
     */
    protected $types;
    /**
     * @var FileRepository
     */
    protected $files;
    /**
     * @var CountryRepository
     */
    private $countries;

    /**
     * Create a new controller instance.
     *
     * @param RepairRepository $repairs
     * @param EngineerRepository $engineers
     * @param TradeRepository $trades
     * @param LaunchRepository $launches
     * @param FileTypeRepository $types
     * @param CountryRepository $countries
     * @param FileRepository $files
     */
    public function __construct(
        RepairRepository $repairs,
        EngineerRepository $engineers,
        TradeRepository $trades,
        LaunchRepository $launches,
        FileTypeRepository $types,
        CountryRepository $countries,
        FileRepository $files
    )
    {
        $this->repairs = $repairs;
        $this->engineers = $engineers;
        $this->trades = $trades;
        $this->launches = $launches;
        $this->types = $types;
        $this->files = $files;
        $this->countries = $countries;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('site::repair.index');
        $this->repairs->trackFilter();

        return view('site::repair.index', [
            'repository' => $this->repairs,
            'items'      => $this->repairs->paginate(config('site.per_page.repair', 10), [env('DB_PREFIX', '') . 'repairs.*'])
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param Repair $repair
     * @return \Illuminate\Http\Response
     */
    public function show(Repair $repair)
    {
        return view('site::repairs.show', ['repair' => $repair]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param RepairRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(RepairRequest $request)
    {
        $this->authorize('create', Repair::class);

        $engineers = $this->engineers
            ->applyFilter(new BelongsUserFilter())
            ->applyFilter(new ByNameSortFilter())
            ->all();
        $trades = $this->trades
            ->applyFilter(new BelongsUserFilter())
            ->applyFilter(new ByNameSortFilter())
            ->all();
        $launches = $this->launches
            ->applyFilter(new BelongsUserFilter())
            ->applyFilter(new ByNameSortFilter())
            ->all();
        $countries = $this->countries
            ->applyFilter(new CountryEnabledFilter())
            ->applyFilter(new CountrySortFilter())
            ->all();
        $types = $this->types->all();

        $files = collect([]);
        $old = $request->old('file');
        if (!is_null($old) && is_array($old)) {
            foreach ($old as $type_id => $values) {
                foreach ($values as $file_id) {
                    $files->push(File::findOrFail($file_id));
                }
            }
        }

        return view('site::repair.create', compact('engineers', 'trades', 'launches', 'countries', 'types', 'files'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RepairRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RepairRequest $request)
    {

        $this->authorize('create', Repair::class);


        $repair = $this->repairs->create($request->except(['_token', '_method', '_create', 'file', 'parts']));
        if($request->filled('file.*')){
            foreach ($request->input('file.*') as $file_id) {
                $this->files->update(['repair_id' => $repair->id], $file_id);
            }
        }

        $parts = collect($request->input('parts'))->values()->toArray();
        $repair->parts()->createMany($parts);
        $route = $request->input('_create') == 1 ? 'repairs.create' : 'repairs.index';

        return redirect()->route($route)->with('success', trans('site::repair.created'));
    }
}