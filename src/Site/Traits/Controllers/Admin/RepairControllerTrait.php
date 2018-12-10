<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Http\Request;
use QuadStudio\Service\Site\Events\RepairStatusEvent;
use QuadStudio\Service\Site\Exports\Excel\RepairExcel;
use QuadStudio\Service\Site\Filters\FileType\ModelHasFilesFilter;
use QuadStudio\Service\Site\Filters\Repair\RegionFilter;
use QuadStudio\Service\Site\Filters\Repair\ScSearchFilter;
use QuadStudio\Service\Site\Http\Requests\MessageRequest;
use QuadStudio\Service\Site\Models\Repair;
use QuadStudio\Service\Site\Repositories\FileTypeRepository;
use QuadStudio\Service\Site\Repositories\MessageRepository;
use QuadStudio\Service\Site\Repositories\RepairRepository;
use QuadStudio\Service\Site\Repositories\RepairStatusRepository;

trait RepairControllerTrait
{
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
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->repairs->trackFilter();
        $this->repairs->pushTrackFilter(RegionFilter::class);
        $this->repairs->pushTrackFilter(ScSearchFilter::class);
        if ($request->has('excel')) {
            $excel = new RepairExcel();
            $excel->render($this->repairs);
        }
        return view('site::admin.repair.index', [
            'repository' => $this->repairs,
            'repairs'    => $this->repairs->paginate((isset($_GET['filter']) ? 10000 : config('site.per_page.repair', 10)), ['repairs.*'])
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
        $files = $repair->files;
        $this->types->applyFilter((new ModelHasFilesFilter())->setId($repair->id)->setMorph('repairs'));
        $types = $this->types->all();

        return view('site::admin.repair.show', compact('repair', 'statuses', 'fails', 'files', 'types'));
    }

    /**
     * @param Request $request
     * @param Repair $repair
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function status(Request $request, Repair $repair)
    {
        $repair->setStatus($request->input('repair.status_id'));
        if ($request->filled('message.text')) {
            $repair->messages()->save($message = $request->user()->outbox()->create($request->input('message')));
        }
        $repair->fails()->delete();
        if ($request->filled('fail')) {
            $repair->fails()->createMany($request->input('fail'));
        }

        event(new RepairStatusEvent($repair, $request->input('message.text')));

        return redirect()->route('admin.repairs.show', $repair)->with('success', trans('site::repair.status_updated'));
    }


    public function message(MessageRequest $request, Repair $repair)
    {
        $repair->messages()->save($request->user()->outbox()->create($request->input('message')));

        return redirect()->route('admin.repairs.show', $repair)->with('success', trans('site::message.created'));
    }

}