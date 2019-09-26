<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Http\Request;
use QuadStudio\Service\Site\Concerns\StoreMessages;
use QuadStudio\Service\Site\Events\RepairStatusChangeEvent;
use QuadStudio\Service\Site\Exports\Excel\RepairExcel;
use QuadStudio\Service\Site\Filters\Repair\ContragentSearchFilter;
use QuadStudio\Service\Site\Filters\Repair\RepairHasSerialBoolFilter;
use QuadStudio\Service\Site\Filters\FileType\ModelHasFilesFilter;
use QuadStudio\Service\Site\Filters\Repair\RepairIsFoundSerialFilter;
use QuadStudio\Service\Site\Filters\Repair\RegionFilter;
use QuadStudio\Service\Site\Filters\Repair\RepairPerPageFilter;
use QuadStudio\Service\Site\Filters\Repair\RepairUserFilter;
use QuadStudio\Service\Site\Filters\Repair\ScSearchFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\RepairRequest;
use QuadStudio\Service\Site\Http\Requests\MessageRequest;
use QuadStudio\Service\Site\Models\Repair;
use QuadStudio\Service\Site\Models\RepairStatus;
use QuadStudio\Service\Site\Repositories\FileTypeRepository;
use QuadStudio\Service\Site\Repositories\MessageRepository;
use QuadStudio\Service\Site\Repositories\RepairRepository;
use QuadStudio\Service\Site\Repositories\RepairStatusRepository;

class RepairController
{

    use StoreMessages;
    /**
     * @var RepairRepository
     */
    protected $repairs;
    protected $statuses;
    protected $types;
    protected $messages;

    /**
     * Create a new controller instance.
     *
     * @param RepairRepository $repairs
     * @param RepairStatusRepository $statuses
     * @param FileTypeRepository $types
     * @param MessageRepository $messages
     */
    public function __construct(
        RepairRepository $repairs,
        RepairStatusRepository $statuses,
        FileTypeRepository $types,
        MessageRepository $messages
    )
    {
        $this->repairs = $repairs;
        $this->statuses = $statuses;
        $this->types = $types;
        $this->messages = $messages;
    }

	/**
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \PhpOffice\PhpSpreadsheet\Exception
	 */
    public function index(Request $request)
    {
        $this->repairs->trackFilter();
        $this->repairs->pushTrackFilter(RegionFilter::class);
        $this->repairs->pushTrackFilter(RepairHasSerialBoolFilter::class);
        $this->repairs->pushTrackFilter(RepairIsFoundSerialFilter::class);
        $this->repairs->pushTrackFilter(RepairUserFilter::class);
        $this->repairs->pushTrackFilter(ScSearchFilter::class);
        $this->repairs->pushTrackFilter(ContragentSearchFilter::class);
        $this->repairs->pushTrackFilter(RepairPerPageFilter::class);
        if ($request->has('excel')) {
            (new RepairExcel())->setRepository($this->repairs)->render();
        }

        return view('site::admin.repair.index', [
            'repository' => $this->repairs,
            'repairs'    => $this->repairs->paginate($request->input('filter.per_page', config('site.per_page.repair', 10)), ['repairs.*'])
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
        $statuses = RepairStatus::query()->where('id', '!=', $repair->getAttribute('status_id'))->orderBy('sort_order')->get();
        $fails = $repair->fails;
        $files = $repair->files;
        $this->types->applyFilter((new ModelHasFilesFilter())->setId($repair->id)->setMorph('repairs'));
        $file_types = $this->types->all();

        return view('site::admin.repair.show', compact('repair', 'statuses', 'fails', 'files', 'file_types'));
    }

    /**
     * @param RepairRequest $request
     * @param Repair $repair
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(RepairRequest $request, Repair $repair)
    {

        $repair->update($request->input('repair'));

        $repair->fails()->delete();
        if ($request->filled('fail')) {
            $repair->fails()->createMany($request->input('fail'));
        }

        event(new RepairStatusChangeEvent($repair));

        return redirect()->route('admin.repairs.show', $repair)->with('success', trans('site::repair.updated'));
    }

    /**
     * @param \QuadStudio\Service\Site\Http\Requests\MessageRequest $request
     * @param \QuadStudio\Service\Site\Models\Repair $repair
     * @return \Illuminate\Http\JsonResponse
     */
    public function message(MessageRequest $request, Repair $repair)
    {
        return $this->storeMessage($request, $repair);
    }

}