<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Concerns\StoreMessages;
use QuadStudio\Service\Site\Events\MountingCreateEvent;
use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Filters\FileType\ModelHasFilesFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingPerPageFilter;
use QuadStudio\Service\Site\Http\Requests\MessageRequest;
use QuadStudio\Service\Site\Http\Requests\MountingRequest;
use QuadStudio\Service\Site\Http\Resources\ProductResource;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\File;
use QuadStudio\Service\Site\Models\FileType;
use QuadStudio\Service\Site\Models\Mounting;
use QuadStudio\Service\Site\Models\MountingSource;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Repositories\ContragentRepository;
use QuadStudio\Service\Site\Repositories\CountryRepository;
use QuadStudio\Service\Site\Repositories\EngineerRepository;
use QuadStudio\Service\Site\Repositories\EquipmentRepository;
use QuadStudio\Service\Site\Repositories\FileRepository;
use QuadStudio\Service\Site\Repositories\FileTypeRepository;
use QuadStudio\Service\Site\Repositories\MountingRepository;
use QuadStudio\Service\Site\Repositories\TradeRepository;

class MountingController extends Controller
{

    use AuthorizesRequests, StoreMessages;
    /**
     * @var MountingRepository
     */
    protected $mountings;
    /**
     * @var EngineerRepository
     */
    protected $engineers;
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
     * Create a new controller instance.
     *
     * @param MountingRepository $mountings
     * @param EngineerRepository $engineers
     * @param TradeRepository $trades
     * @param FileTypeRepository $types
     * @param CountryRepository $countries
     * @param EquipmentRepository $equipments
     * @param FileRepository $files
     * @param ContragentRepository $contragents
     */
    public function __construct(
        MountingRepository $mountings,
        EngineerRepository $engineers,
        TradeRepository $trades,
        FileTypeRepository $types,
        CountryRepository $countries,
        EquipmentRepository $equipments,
        FileRepository $files,
        ContragentRepository $contragents

    )
    {
        $this->mountings = $mountings;
        $this->engineers = $engineers;
        $this->trades = $trades;
        $this->types = $types;
        $this->files = $files;
        $this->countries = $countries;
        $this->equipments = $equipments;
        $this->contragents = $contragents;
    }

    /**
     * @param MountingRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(MountingRequest $request)
    {

        $this->mountings->trackFilter();
        $this->mountings->applyFilter(new BelongsUserFilter());
        $this->mountings->pushTrackFilter(MountingPerPageFilter::class);

        return view('site::mounting.index', [
            'repository' => $this->mountings,
            'mountings'  => $this->mountings->paginate($request->input('filter.per_page', config('site.per_page.mounting', 8)), ['mountings.*'])
        ]);
    }


    /**
     * @param Mounting $mounting
     * @return \Illuminate\Http\Response
     */
    public function show(Mounting $mounting)
    {
        $this->authorize('view', $mounting);
        $this->types->applyFilter((new ModelHasFilesFilter())->setId($mounting->id)->setMorph('mountings'));
        $file_types = $this->types->all();
        $files = $mounting->files;

        return view('site::mounting.show', compact(
            'mounting',
            'file_types',
            'files'
        ));
    }

    /**
     * @param MountingRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(MountingRequest $request)
    {

        $this->authorize('create', Mounting::class);

        $engineers = $request->user()->engineers()->orderBy('name')->get();
        $trades = $request->user()->trades()->orderBy('name')->get();
        $contragents = $request->user()->contragents()->orderBy('name')->get();
        $countries = Country::query()->where('enabled', 1)->orderBy('name')->get();
        $file_types = FileType::query()->where('enabled', 1)->where('group_id', 4)->orderBy('sort_order')->get();
        $mounting_sources = MountingSource::query()->get();
        $products = Product::query()

            ->whereNotNull('sku')
            ->where('enabled', 1)
            ->where('type_id', 1)
            ->orderBy('name')
            ->with('mounting_bonus')
            ->get();

        $files = $this->getFiles($request);

        $selected_product = Product::query()->findOrNew(old('mounting.product_id'));
        //dd($request->all());

        return view('site::mounting.create', compact(
            'engineers',
            'trades',
            'contragents',
            'countries',
            'mounting_sources',
            'file_types',
            'files',
            'selected_product',
            'products'
        ));
    }

    /**
     * @param MountingRequest $request
     * @param Mounting|null $mounting
     * @return \Illuminate\Support\Collection
     */
    private function getFiles(MountingRequest $request, Mounting $mounting = null)
    {
        $files = collect([]);
        $old = $request->old('file');
        //dd($request->file);
        if (!is_null($old) && is_array($old)) {
            foreach ($old as $type_id => $values) {
                foreach ($values as $file_id) {
                    $files->push(File::query()->findOrFail($file_id));
                }
            }
        } elseif (!is_null($mounting)) {
            $files = $files->merge($mounting->files);
        }

        return $files;
    }

    /**
     * @param  MountingRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MountingRequest $request)
    {
        $mounting = $request->user()->mountings()->create($request->input('mounting'));
        $this->setFiles($request, $mounting);

        event(new MountingCreateEvent($mounting));

        return redirect()->route('mountings.index')->with('success', trans('site::mounting.created'));
    }

    /**
     * @param MountingRequest $request
     * @param Mounting $mounting
     */
    private function setFiles(MountingRequest $request, Mounting $mounting)
    {
        $mounting->detachFiles();
        if ($request->filled('file')) {
            foreach ($request->input('file') as $type_id => $values) {
                foreach ($values as $file_id) {
                    $mounting->files()->save(File::find($file_id));
                }
            }
        }
    }

    /**
     * @param \QuadStudio\Service\Site\Http\Requests\MessageRequest $request
     * @param \QuadStudio\Service\Site\Models\Mounting $mounting
     * @return \Illuminate\Http\JsonResponse
     */
    public function message(MessageRequest $request, Mounting $mounting)
    {
        return $this->storeMessage($request, $mounting);
    }

}