<?php

namespace QuadStudio\Service\Site\Traits\Controllers;


use QuadStudio\Service\Site\Facades\Cart;
use QuadStudio\Service\Site\Http\Requests\CartItemRequest;
use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Repositories\ContragentRepository;

trait CartControllerTrait
{
    /**
     * @var ContragentRepository
     */
    private $contragents;

    /**
     * CartControllerTrait constructor.
     * @param ContragentRepository $contragents
     */
    public function __construct(ContragentRepository $contragents)
    {

        $this->contragents = $contragents;
    }

    /**
     * Show the shop index page
     *
     * @param CartItemRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(CartItemRequest $request)
    {
        $contragents = $request->user()->contragents;

        return view('site::cart.index', compact('contragents'));
    }

    /**
     * @param CartItemRequest $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(CartItemRequest $request, Product $product)
    {
        Cart::add(array_merge($product->toCart(), $request->only(['quantity'])));

        return response()->json([
            'replace' => [
                '.cart-nav' => view('site::cart.nav')->render(),
                '#cart-table' => view('site::cart.item.rows')->render()
            ],
            'update'  => [
                '#confirm-add-to-cart .modal-body' => $request->input('name')
            ]
        ]);
    }

    /**
     * @param CartItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CartItemRequest $request)
    {
        Cart::update($request->all());


        return response()->json([
            'replace' => [
                '#cart-item-' . $request->input('product_id') => view('site::cart.item.row')->with('item', Cart::get($request->input('product_id')))->render(),
                '.cart-nav'                                   => view('site::cart.nav')->render()
            ],
            'update'  => [
                '#cart-total'  => Cart::price_format(Cart::total()),
                '#cart-weight' => Cart::weight_format(),
            ]
        ]);
    }

    /**
     * @param CartItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(CartItemRequest $request)
    {
        Cart::remove($request->input('product_id'));

        return response()->json([
            'refresh' => Cart::isEmpty(),
            'replace' => [
                '#cart-item-' . $request->input('product_id') => '',
                '.cart-nav'                                   => view('site::cart.nav')->render()
            ],
            'update'  => [
                '#cart-total'  => Cart::price_format(Cart::total()),
                '#cart-weight' => Cart::weight_format(),
            ]
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear()
    {
        Cart::clear();

        return redirect()->route('cart');
    }
}