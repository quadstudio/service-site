<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Concerns\StoreMessages;
use QuadStudio\Service\Site\Events\OrderStatusChangeEvent;
use QuadStudio\Service\Site\Filters\Order\DistributorFilter;
use QuadStudio\Service\Site\Http\Requests\MessageRequest;
use QuadStudio\Service\Site\Models\Order;
use QuadStudio\Service\Site\Models\OrderStatus;
use QuadStudio\Service\Site\Repositories\OrderRepository;

class DistributorController extends Controller
{

    use AuthorizesRequests, StoreMessages;

    /**
     * @var OrderRepository
     */
    protected $orders;

    /**
     * Create a new controller instance.
     *
     * @param OrderRepository $orders
     */
    public function __construct(OrderRepository $orders)
    {
        $this->orders = $orders;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->orders->trackFilter();
        $this->orders->applyFilter(new DistributorFilter());


        return view('site::distributor.index', [
            'orders'     => $this->orders->paginate(config('site.per_page.order', 8)),
            'repository' => $this->orders,
        ]);
    }

	/**
	 * @param Order $order
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function show(Order $order)
    {

        $this->authorize('distributor', $order);

        return view('site::distributor.show', compact('order'));
    }

    /**
     * @param Request $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Order $order)
    {
        $order->fill($request->input('order'));
        $status_changed = $order->isDirty('status_id');
        $order->save();
        if ($status_changed) {
            event(new OrderStatusChangeEvent($order));
        }

        return redirect()->route('distributors.show', $order)->with('success', trans('site::order.updated'));
    }

    /**
     * @param \QuadStudio\Service\Site\Http\Requests\MessageRequest $request
     * @param \QuadStudio\Service\Site\Models\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function message(MessageRequest $request, Order $order)
    {
        return $this->storeMessage($request, $order);
    }

}