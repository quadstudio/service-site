<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Concerns\StoreMessages;
use QuadStudio\Service\Site\Events\MountingStatusChangeEvent;
use QuadStudio\Service\Site\Exports\Excel\MountingExcel;
use QuadStudio\Service\Site\Filters\Authorization\MountingUserFilter;
use QuadStudio\Service\Site\Filters\FileType\ModelHasFilesFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingPerPageFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\MountingRequest;
use QuadStudio\Service\Site\Http\Requests\MessageRequest;
use QuadStudio\Service\Site\Models\Mounting;
use QuadStudio\Service\Site\Models\MountingStatus;
use QuadStudio\Service\Site\Repositories\FileTypeRepository;
use QuadStudio\Service\Site\Repositories\MountingRepository;

class MountingController extends Controller
{

    use StoreMessages;

    /**
     * @var MountingRepository
     */
    private $mountings;
    /**
     * @var FileTypeRepository
     */
    private $types;

    /**
     * MountingController constructor.
     * @param MountingRepository $mountings
     * @param FileTypeRepository $types
     */
    public function __construct(
        MountingRepository $mountings,
        FileTypeRepository $types
    )
    {

        $this->mountings = $mountings;
        $this->types = $types;
    }

    /**
     * @param MountingRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(MountingRequest $request)
    {
        $this->mountings->trackFilter();

        $this->mountings->pushTrackFilter(MountingUserFilter::class);
        $this->mountings->pushTrackFilter(MountingPerPageFilter::class);
        $mountings = $this->mountings->paginate($request->input('filter.per_page', config('site.per_page.mounting', 10)), ['mountings.*']);
        $repository = $this->mountings;

        if ($request->has('excel')) {
            (new MountingExcel())->setRepository($this->mountings)->render();
        }

        return view('site::admin.mounting.index', compact('mountings', 'repository'));
    }

    /**
     * @param Mounting $mounting
     * @return \Illuminate\Http\Response
     */
    public function show(Mounting $mounting)
    {

        $this->types->applyFilter((new ModelHasFilesFilter())->setId($mounting->id)->setMorph('mountings'));
        $file_types = $this->types->all();
        $files = $mounting->files;
        $mounting_statuses = MountingStatus::query()->where('id', '!=', $mounting->getAttribute('status_id'))->orderBy('sort_order')->get();

        return view('site::admin.mounting.show', compact(
            'mounting',
            'file_types',
            'files',
            'mounting_statuses'
        ));
    }

    /**
     * @param  MountingRequest $request
     * @param  Mounting $mounting
     * @return \Illuminate\Http\Response
     */
    public function update(MountingRequest $request, Mounting $mounting)
    {

        $mounting->fill($request->input('mounting'));
        $status_changed = $mounting->isDirty('status_id');
        $mounting->save();
        if ($status_changed) {
            event(new MountingStatusChangeEvent($mounting));
        }

        return redirect()->route('admin.mountings.show', $mounting)->with('success', trans('site::mounting.updated'));
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