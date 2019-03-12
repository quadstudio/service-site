<?php

namespace QuadStudio\Service\Site\Traits\Controllers;


use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Filters\Order\DistributorFilter;
use QuadStudio\Service\Site\Models\Order;
use QuadStudio\Service\Site\Repositories\OrderRepository;

trait DistributorControllerTrait
{

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
     * Show the shop index page
     *
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
     * Display the specified resource.
     *
     * @param int $order_id
     * @return \Illuminate\Http\Response
     */
    public function show($order_id)
    {
        $order = Order::query()->findOrFail($order_id);

        $this->authorize('distributor', $order);

        return view('site::distributor.show', compact('order'));
    }

}