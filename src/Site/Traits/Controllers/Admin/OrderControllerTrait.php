<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;



//use QuadStudio\Service\Shop\Http\Requests\Order As Request;
use QuadStudio\Service\Site\Events\OrderScheduleEvent;
use QuadStudio\Service\Site\Filters\Order\ScSearchFilter;
use QuadStudio\Service\Site\Models\Order;
use QuadStudio\Service\Site\Repositories\OrderRepository As Repository;

trait OrderControllerTrait
{
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->orders->trackFilter();
        $this->orders->pushTrackFilter(ScSearchFilter::class);
        return view('site::admin.order.index', [
            'orders' => $this->orders->paginate(config('site.per_page.order', 8)),
            'repository' => $this->orders,
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('site::admin.order.show', compact('order'));
    }

    /**
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function schedule(Order $order)
    {
        $this->authorize('schedule', $order);
        event(new OrderScheduleEvent($order));

        return redirect()->route('admin.orders.show', $order)->with('success', trans('site::schedule.created'));

    }

}