<?php

namespace QuadStudio\Service\Site\Traits\Controllers;


use QuadStudio\Service\Site\Http\Requests\CartItem As Request;
use QuadStudio\Service\Site\Facades\Cart;

trait CartControllerTrait
{


    /**
     * Show the shop index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dump(Cart::items());
        return view('site::cart.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        Cart::add($request->except('_token'));

        return response()->json([
            'replace' => [
                '.cart-nav' => view('site::cart.nav')->render()
            ],
            'update' => [
                '#confirm-add-to-cart .modal-body' => $request->input('name')
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        Cart::update($request->all());


        return response()->json([
            'replace' => [
                '#cart-item-' . $request->input('product_id') => view('site::cart.item.row')->with('item', Cart::get($request->input('product_id')))->render(),
                '.cart-nav' => view('site::cart.nav')->render()
            ],
            'update'  => [
                '#cart-total' => Cart::price_format(Cart::total()),
                '#cart-weight' => Cart::weight_format(),
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(Request $request)
    {
        Cart::remove($request->input('product_id'));

        return response()->json([
            'refresh' => Cart::isEmpty(),
            'replace' => [
                '#cart-item-' . $request->input('product_id') => '',
                '.cart-nav' => view('site::cart.nav')->render()
            ],
            'update'  => [
                '#cart-total' => Cart::price_format(Cart::total()),
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