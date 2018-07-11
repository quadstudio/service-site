<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Filters\OrderDateFilter;
use QuadStudio\Service\Site\Http\Requests\Order As Request;
use QuadStudio\Service\Site\Models\Order;
use QuadStudio\Service\Site\Repositories\OrderRepository;

trait OrderControllerTrait
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
        $this->orders->pushFilter(new BelongsUserFilter);
        $this->orders->pushFilter(new OrderDateFilter);
        return view('order.index', [
            'items' => $this->orders->paginate(config('site.per_page.order', 8)),
            'repository' => $this->orders,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = $this->orders->create($request->except('_token'));

        return redirect()->route('orders.show', $order)->with('message', trans('shop::messages.order.success', ['order' => $order->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('order.show', ['order' => $order]);
    }

}