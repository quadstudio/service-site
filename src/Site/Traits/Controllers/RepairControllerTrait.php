<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Filters\ByNameSortFilter;
use QuadStudio\Service\Site\Filters\CountryEnabledFilter;
use QuadStudio\Service\Site\Filters\CountrySortFilter;
use QuadStudio\Service\Site\Filters\FileType\ModelHasFilesFilter;
use QuadStudio\Service\Site\Filters\FileType\RepairFilter;
use QuadStudio\Service\Site\Filters\FileType\SortFilter;
use QuadStudio\Service\Site\Http\Requests\RepairRequest;
use QuadStudio\Service\Site\Models\File;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Models\Repair;
use QuadStudio\Service\Site\Repositories\ContragentRepository;
use QuadStudio\Service\Site\Repositories\CountryRepository;
use QuadStudio\Service\Site\Repositories\DifficultyRepository;
use QuadStudio\Service\Site\Repositories\DistanceRepository;
use QuadStudio\Service\Site\Repositories\EngineerRepository;
use QuadStudio\Service\Site\Repositories\EquipmentRepository;
use QuadStudio\Service\Site\Repositories\FileRepository;
use QuadStudio\Service\Site\Repositories\FileTypeRepository;
use QuadStudio\Service\Site\Repositories\LaunchRepository;
use QuadStudio\Service\Site\Repositories\RepairRepository;
use QuadStudio\Service\Site\Repositories\TradeRepository;

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
     * @var EquipmentRepository
     */
    private $equipments;
    /**
     * @var ContragentRepository
     */
    private $contragents;
    /**
     * @var DistanceRepository
     */
    private $distances;
    /**
     * @var DifficultyRepository
     */
    private $difficulties;

    /**
     * Create a new controller instance.
     *
     * @param RepairRepository $repairs
     * @param EngineerRepository $engineers
     * @param TradeRepository $trades
     * @param LaunchRepository $launches
     * @param FileTypeRepository $types
     * @param CountryRepository $countries
     * @param EquipmentRepository $equipments
     * @param FileRepository $files
     * @param ContragentRepository $contragents
     * @param DistanceRepository $distances
     * @param DifficultyRepository $difficulties
     */
    public function __construct(
        RepairRepository $repairs,
        EngineerRepository $engineers,
        TradeRepository $trades,
        LaunchRepository $launches,
        FileTypeRepository $types,
        CountryRepository $countries,
        EquipmentRepository $equipments,
        FileRepository $files,
        ContragentRepository $contragents,
        DistanceRepository $distances,
        DifficultyRepository $difficulties
    )
    {
        $this->repairs = $repairs;
        $this->engineers = $engineers;
        $this->trades = $trades;
        $this->launches = $launches;
        $this->types = $types;
        $this->files = $files;
        $this->countries = $countries;
        $this->equipments = $equipments;
        $this->contragents = $contragents;
        $this->distances = $distances;
        $this->difficulties = $difficulties;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->repairs->trackFilter();
        $this->repairs->applyFilter(new BelongsUserFilter());

        return view('site::repair.index', [
            'repository' => $this->repairs,
            'repairs'    => $this->repairs->paginate(config('site.per_page.repair', 10), [env('DB_PREFIX', '') . 'repairs.*'])
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
        $statuses = $repair->statuses()->get();
        $fails = $repair->fails;
        $this->types->applyFilter((new ModelHasFilesFilter())->setId($repair->id)->setMorph('repairs'));
        $types = $this->types->all();
        $files = $repair->files;

        return view('site::repair.show', compact('repair', 'fails', 'types', 'files', 'statuses'));
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
        $contragents = $request->user()->contragents;
        $countries = $this->countries
            ->applyFilter(new CountryEnabledFilter())
            ->applyFilter(new CountrySortFilter())
            ->all();
        $this->types->applyFilter(new SortFilter());
        $this->types->applyFilter(new RepairFilter());
        $types = $this->types->all();
        $difficulties = $this->difficulties->all();
        $distances = $this->distances->all();
        $parts = $this->getParts($request);
        $files = $this->getFiles($request);
        $fails = collect([]);
        $product = old('product_id', false) ? Product::find(old('product_id'))->name : null;

        return view('site::repair.create', compact(
            'engineers',
            'trades',
            'contragents',
            'launches',
            'countries',
            'types',
            'files',
            'parts',
            'fails',
            'product',
            'difficulties',
            'distances'
        ));
    }

    /**
     * @param RepairRequest $request
     * @param Repair|null $repair
     * @return \Illuminate\Support\Collection
     */
    private function getParts(RepairRequest $request, Repair $repair = null)
    {

        $parts = collect([]);
        $old = $request->old('parts');
        if (!is_null($old) && is_array($old)) {

            foreach ($old as $product_id => $values) {
                $product = Product::findOrFail($values['product_id']);
                $parts->put($product->id, collect([
                    'product_id' => $product->id,
                    'sku'        => $product->sku,
                    'cost'       => $product->price()->exists ? $product->price()->price() : '',
                    'format'     => $product->price()->exists ? $product->price()->format() : '',
                    'name'       => $product->name,
                    'count'      => $values['count'],
                ]));
            }
        } elseif (!is_null($repair)) {
            foreach ($repair->parts as $part) {
                $parts->put($part->product_id, collect([
                    'product_id' => $part->product_id,
                    'sku'        => $part->product->sku,
                    'cost'       => $part->product->price()->exists ? $part->product->price()->price() : '',
                    'format'     => $part->product->price()->exists ? $part->product->price()->format() : '',
                    'name'       => $part->product->name,
                    'count'      => $part->count,
                ]));
            }
        }

        return $parts;
    }

    /**
     * @param RepairRequest $request
     * @param Repair|null $repair
     * @return \Illuminate\Support\Collection
     */
    private function getFiles(RepairRequest $request, Repair $repair = null)
    {
        $files = collect([]);
        $old = $request->old('file');
        if (!is_null($old) && is_array($old)) {
            foreach ($old as $type_id => $values) {
                foreach ($values as $file_id) {
                    $files->push(File::findOrFail($file_id));
                }
            }
        } elseif (!is_null($repair)) {
            $files = $files->merge($repair->files);
        }

        return $files;
    }

    /**
     * @param RepairRequest $request
     * @param Repair $repair
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(RepairRequest $request, Repair $repair)
    {
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
        $this->types->applyFilter(new SortFilter());
        $this->types->applyFilter(new RepairFilter());
        $types = $this->types->all();
        $parts = $this->getParts($request, $repair);
        $files = $this->getFiles($request, $repair);
        $difficulties = $this->difficulties->all();
        $distances = $this->distances->all();
        $statuses = $repair->statuses()->get();

        $fails = $repair->fails;

        //dd(old('allow_road', $repair->allow_road));
        return view('site::repair.edit', compact(
            'repair',
            'engineers',
            'trades',
            'launches',
            'countries',
            'statuses',
            'types',
            'files',
            'parts',
            'fails',
            'difficulties',
            'distances'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RepairRequest $request
     * @param Repair $repair
     * @return \Illuminate\Http\Response
     */
    public function update(RepairRequest $request, Repair $repair)
    {

        $repair->update($request->except(['_token', '_method', '_create', 'file', 'parts']));
        if ($request->filled('message.text')) {
            $repair->messages()->save($message = $request->user()->outbox()->create($request->input('message')));
        }
        $this->setFiles($request, $repair);

        if ($request->filled('parts')) {
            $repair->parts()->delete();

            $parts = collect($request->input('parts'))->values()->toArray();
            $repair->parts()->createMany($parts);
        }

        return redirect()->route('repairs.show', $repair)->with('success', trans('site::repair.updated'));
    }

    /**
     * @param RepairRequest $request
     * @param Repair $repair
     */
    private function setFiles(RepairRequest $request, Repair $repair)
    {
        $repair->detachFiles();

        if ($request->filled('file')) {
            foreach ($request->input('file') as $type_id => $values) {
                foreach ($values as $file_id) {
                    $repair->files()->save(File::find($file_id));
                }
            }
        }
        //$this->files->deleteLostFiles();
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
        $request->user()->repairs()->save($repair = $this->repairs->create($request->except(['_token', '_method', '_create', 'file', 'parts'])));
        $this->setFiles($request, $repair);
        if ($request->filled('parts')) {
            $parts = collect($request->input('parts'))->values()->toArray();
            $repair->parts()->createMany($parts);
        }
        $route = $request->input('_create') == 1 ? 'repairs.create' : 'repairs.index';

        return redirect()->route($route)->with('success', trans('site::repair.created'));
    }
}