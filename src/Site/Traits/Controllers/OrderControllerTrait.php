<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Events\OrderCreateEvent;
use QuadStudio\Service\Site\Facades\Cart;
use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Filters\OrderDateFilter;
use QuadStudio\Service\Site\Http\Requests\OrderRequest;
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

        return view('site::order.index', [
            'orders'     => $this->orders->paginate(config('site.per_page.order', 8)),
            'repository' => $this->orders,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  OrderRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {

        $request->user()->orders()->save($order = $this->orders->create($request->only(['status_id', 'contragent_id'])));
        if ($request->filled('message.text')) {
            $order->messages()->save($request->user()->outbox()->create($request->input('message')));
        }
        $order->items()->createMany(Cart::toArray());
        Cart::clear();

        event(new OrderCreateEvent($order));

        return redirect()->route('orders.show', $order)->with('success', trans('site::order.created'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('site::order.create');
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

        return view('site::order.show', compact('order'));
    }

}