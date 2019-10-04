<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Concerns\StoreFiles;
use QuadStudio\Service\Site\Events\OrderScheduleEvent;
use QuadStudio\Service\Site\Events\OrderStatusChangeEvent;
use QuadStudio\Service\Site\Exports\Excel\OrdersExcel;
use QuadStudio\Service\Site\Filters\Order\OrderAddressSelectFilter;
use QuadStudio\Service\Site\Filters\Order\OrderInStockTypeSelectFilter;
use QuadStudio\Service\Site\Filters\Order\OrderPerPageFilter;
use QuadStudio\Service\Site\Filters\Order\OrderUserSelectFilter;
use QuadStudio\Service\Site\Filters\Order\ScSearchFilter;
use QuadStudio\Service\Site\Http\Requests\FileRequest;
use QuadStudio\Service\Site\Http\Requests\Admin\OrderRequest;
use QuadStudio\Service\Site\Http\Requests\MessageRequest;
use QuadStudio\Service\Site\Models\Order;
use QuadStudio\Service\Site\Repositories\OrderRepository as Repository;

class OrderController extends Controller
{

	use AuthorizesRequests, StoreFiles;
	/**
	 * @var Repository
	 */
	protected $orders;

	/**
	 * Create a new controller instance.
	 *
	 * @param Repository $orders
	 */
	public function __construct(Repository $orders)
	{
		$this->middleware('auth');
		$this->orders = $orders;
	}

	/**
	 * Show the shop index page
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \PhpOffice\PhpSpreadsheet\Exception
	 */
	public function index(Request $request)
	{
		$this->orders->trackFilter();
		$this->orders->pushTrackFilter(ScSearchFilter::class);
		$this->orders->pushTrackFilter(OrderAddressSelectFilter::class);
		$this->orders->pushTrackFilter(OrderInStockTypeSelectFilter::class);
		$this->orders->pushTrackFilter(OrderUserSelectFilter::class);
		$this->orders->pushTrackFilter(OrderPerPageFilter::class);

		if ($request->has('excel')) {
			(new OrdersExcel())->setRepository($this->orders)->render();
		}

		return view('site::admin.order.index', [
			'orders' => $this->orders->paginate($request->input('filter.per_page', config('site.per_page.order', 10)), ['orders.*']),
			'repository' => $this->orders,
		]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  Order $order
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Order $order)
	{
		$file = $order->file;

		return view('site::admin.order.show', compact('order', 'file'));
	}

	/**
	 * @param FileRequest $request
	 * @param Order $order
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
	public function payment(FileRequest $request, Order $order)
	{
		return $this->storeFile($request, $order);
	}

	/**
	 * @param Order $order
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function schedule(Order $order)
	{
		$this->authorize('schedule', $order);
		event(new OrderScheduleEvent($order));

		return redirect()->route('admin.orders.show', $order)->with('success', trans('site::schedule.created'));

	}

	/**
	 * @param OrderRequest $request
	 * @param  Order $order
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(OrderRequest $request, Order $order)
	{

		$order->fill($request->input('order'));
		$status_changed = $order->isDirty('status_id');
		$order->save();
		if ($status_changed) {
			event(new OrderStatusChangeEvent($order));
		}

		return redirect()->route('admin.orders.show', $order)->with('success', trans('site::order.updated'));

	}

	public function message(MessageRequest $request, Order $order)
	{
		$order->messages()->save($request->user()->outbox()->create($request->input('message')));

		return redirect()->route('admin.orders.show', $order)->with('success', trans('site::message.created'));
	}

}