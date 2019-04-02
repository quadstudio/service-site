<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\BaseReader;
use QuadStudio\Service\Site\Concerns\StoreMessages;
use QuadStudio\Service\Site\Events\OrderCreateEvent;
use QuadStudio\Service\Site\Facades\Cart;
use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Filters\OrderDateFilter;
use QuadStudio\Service\Site\Http\Requests\MessageRequest;
use QuadStudio\Service\Site\Http\Requests\OrderLoadRequest;
use QuadStudio\Service\Site\Http\Requests\OrderRequest;
use QuadStudio\Service\Site\Models\Order;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Repositories\OrderRepository;
use QuadStudio\Service\Site\Support\OrderLoadFilter;

class OrderController extends Controller
{

    use  AuthorizesRequests, StoreMessages;
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
        //dd($request->all());
        $request->user()->orders()->save($order = $this->orders->create($request->input('order')));
        if ($request->filled('message.text')) {
            $message = $request->input('message');
            $message['receiver_id'] = $order->address->addressable->id;
            $order->messages()->save($request->user()->outbox()->create($message));
        }
        $order->items()->createMany(Cart::toArray());
        Cart::clear();

        event(new OrderCreateEvent($order));

        return redirect()->route('orders.show', $order)->with('success', trans('site::order.created'));
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

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('site::order.create');
    }

    /**
     * @param OrderLoadRequest $request
     * @return \Illuminate\Http\Response
     */
    public function load(OrderLoadRequest $request)
    {
        $inputFileType = ucfirst($request->path->getClientOriginalExtension());
        $filterSubset = new OrderLoadFilter();
        /** @var BaseReader $reader */
        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $reader->setReadFilter($filterSubset);

        $spreadsheet = $reader->load($request->path->getPathname());

        $rowIterator = $spreadsheet->getActiveSheet()->getRowIterator();

        $data = [];

        foreach ($rowIterator as $r => $row) {

            $cellIterator = $row->getCellIterator();

            foreach ($cellIterator as $c => $cell) {


                switch ($c) {
                    case 'A':
                        $sku = (string)trim($cell->getValue());
                        /** @var Product $product */
                        $product = Product::query()->where('sku', $sku)->firstOrFail();

                        break;
                    case 'B':

                        $quantity = (int)$cell->getValue();

                        break;
                }
            }
            Cart::add(array_merge($product->toCart(), compact('quantity')));
        }

        return redirect()->route('orders.create')->with('success', trans('site::order.loaded'));


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

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {

        $this->authorize('delete', $order);

        if ($order->delete()) {
            $redirect = route('orders.index');
        } else {
            $redirect = route('orders.show', $order);
        }
        $json['redirect'] = $redirect;

        return response()->json($json);

    }

}