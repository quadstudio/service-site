<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Concerns\StoreMessages;
use QuadStudio\Service\Site\Exports\Excel\MountingExcel;
use QuadStudio\Service\Site\Filters\Authorization\MountingUserFilter;
use QuadStudio\Service\Site\Filters\FileType\ModelHasFilesFilter;
use QuadStudio\Service\Site\Filters\Mounting\MountingPerPageFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\MountingRequest;
use QuadStudio\Service\Site\Http\Requests\MessageRequest;
use QuadStudio\Service\Site\Models\Mounting;
use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Repositories\FileTypeRepository;
use QuadStudio\Service\Site\Repositories\MountingRepository;
use QuadStudio\Service\Site\Exceptions\Digift\DigiftException;
use QuadStudio\Service\Site\Site\Support\CommentBox;

class MountingController extends Controller
{

	use StoreMessages, ValidatesRequests;

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
	 *
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
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \PhpOffice\PhpSpreadsheet\Exception
	 */
	public function index(Request $request)
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
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Mounting $mounting)
	{

		$this->types->applyFilter((new ModelHasFilesFilter())->setId($mounting->id)->setMorph('mountings'));
		$file_types = $this->types->all();
		$files = $mounting->files;
		$mounting_statuses = $mounting->statuses();
		$digift_user = [];
		if ($mounting->user->digiftUser()->doesntExist()) {
			$digift_user = $mounting->user->getDigiftUserData();
		}
		$commentBox = new CommentBox($mounting);

		return view('site::admin.mounting.show', compact(
			'digift_user',
			'mounting',
			'file_types',
			'files',
			'mounting_statuses',
			'commentBox'
		));
	}

	/**
	 * @param MountingRequest $request
	 * @param Mounting $mounting
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(MountingRequest $request, Mounting $mounting)
	{

		$type = 'success';
		$message = trans('site::mounting.updated');

		try {
			$request->update($mounting);
		} catch (GuzzleException $e) {
			$type = 'error';
			$message = trans('site::digift.error.admin.guzzle', ['message' => $e->getMessage()]);
		} catch (DigiftException $e) {
			$type = 'error';
			$message = trans('site::digift.error.admin.digift', ['message' => $e->getMessage()]);
		} catch (\Exception $e) {
			$type = 'error';
			$message = trans('site::digift.error.admin.unknown', ['message' => $e->getMessage()]);
		} finally {
			return redirect()->route('admin.mountings.show', $mounting)->with($type, $message);
		}

	}

	/**
	 * @param \QuadStudio\Service\Site\Http\Requests\MessageRequest $request
	 * @param \QuadStudio\Service\Site\Models\Mounting $mounting
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function message(MessageRequest $request, Mounting $mounting)
	{
		return $this->storeMessage($request, $mounting);
	}

}