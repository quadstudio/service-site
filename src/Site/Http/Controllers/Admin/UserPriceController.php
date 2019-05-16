<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Models\PriceType;
use QuadStudio\Service\Site\Models\ProductType;
use QuadStudio\Service\Site\Models\User;

class UserPriceController extends Controller
{

    /**
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {

        $user_prices = $user->prices;
        $product_types = ProductType::query()->get();
        $price_types = PriceType::query()->where('enabled', 1)->get();
        $default_price_type = config('site.defaults.user.price_type_id');

        return view('site::admin.user.price.index', compact(
            'user',
            'user_prices',
            'product_types',
            'price_types',
            'default_price_type'
        ));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, User $user)
    {

        $user->prices()->delete();
        $data = [];
        foreach ($request->input('user_price') as $product_type_id => $price_type_id) {
            $data[] = [
                'product_type_id' => $product_type_id,
                'price_type_id'   => $price_type_id,
            ];
        }
        $user->prices()->createMany($data);

        return redirect()->route('admin.users.show', $user)->with('success', trans('site::user_price.updated'));
    }

}