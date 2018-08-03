<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use Illuminate\Support\Facades\Auth;
use QuadStudio\Service\Site\Filters\AddressableFilter;
use QuadStudio\Service\Site\Repositories\AddressRepository;

trait AddressControllerTrait
{

    protected $addresses;

    /**
     * Create a new controller instance.
     *
     * @param AddressRepository $addresses
     */
    public function __construct(AddressRepository $addresses)
    {
        $this->addresses = $addresses;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = Auth::user()->addresses()->get();
        foreach (Auth::user()->contragents as $contragent){
            $addresses = $addresses->merge( $contragent->addresses()->get());
        }
        return view('site::address.index', [
            'addresses'      => $addresses
        ]);
    }

}