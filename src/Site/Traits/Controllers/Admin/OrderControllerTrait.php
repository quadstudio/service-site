<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;



//use QuadStudio\Service\Shop\Http\Requests\Order As Request;
use QuadStudio\Service\Site\Models\Order;
use QuadStudio\Service\Site\Repositories\OrderRepository As Repository;

trait OrderControllerTrait
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
    }

    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->trackFilter();

        return view('site::admin.order.index', [
            'items' => $this->repository->paginate(config('site.per_page.order', 8)),
            'repository' => $this->repository,
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
        return view('site::admin.order.show', ['order' => $order]);
    }

}