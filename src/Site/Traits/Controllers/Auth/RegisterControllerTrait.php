<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Auth;


use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use QuadStudio\Service\Site\Http\Requests\RegisterRequest;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\Contact;
use QuadStudio\Service\Site\Models\Contragent;
use QuadStudio\Service\Site\Models\ContragentType;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Phone;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Models\User;

//use QuadStudio\Service\Site\Http\Requests\User as Request;

trait RegisterControllerTrait
{

    /**
     * @var \Geocoder\StatefulGeocoder
     */
    private $geocoder;

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {

        $countries = Country::enabled()->orderBy('sort_order')->get();
        $address_sc_regions = $address_legal_regions = $address_postal_regions = collect([]);
        if (old('address.sc.country_id', false)) {
            $address_sc_regions = Region::where('country_id', old('address.sc.country_id'))->orderBy('name')->get();
        }
        if (old('address.legal.country_id', false)) {
            $address_legal_regions = Region::where('country_id', old('address.legal.country_id'))->orderBy('name')->get();
        }
        if (old('address.postal.country_id', false)) {
            $address_postal_regions = Region::where('country_id', old('address.postal.country_id'))->orderBy('name')->get();
        }

        $types = ContragentType::all();

        return view('site::auth.register', compact('countries', 'types', 'address_sc_regions', 'address_legal_regions', 'address_postal_regions'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        //dd($request->all());
        $user = $this->createUser($request->all());
        /** @var $contact Contact */
        $user->contacts()->save($contact = Contact::create($request->input('contact')));
        $contact->phones()->save(Phone::create($request->input('phone.contact')));
//        if ($request->filled('sc')) {
//            /** @var $sc Contact */
//            $user->contacts()->save($sc = Contact::create($request->input('sc')));
//            $sc->phones()->save(Phone::create($request->input('phone.sc')));
//        }
        /** @var $address Address */
        $user->addresses()->save($address = Address::create($request->input('address.sc')));
        $address->phones()->save(Phone::create($request->input('phone.sc')));

        /** @var $contragent Contragent */
        $user->contragents()->save($contragent = Contragent::create($request->input('contragent')));
        $contragent->addresses()->saveMany([
            Address::create($request->input('address.legal')),
            Address::create($request->input('address.postal')),
        ]);
        $user->attachRole(config('site.defaults.user.role_id', 2));

        event(new Registered($user));

        return redirect()->route('login')->with('success', trans('site::user.confirm_email', ['email' => $user->getEmailForPasswordReset()]));

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function createUser(array $data)
    {
        return User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'dealer'        => isset($data['dealer']) ? 1 : 0,
            'type_id'       => $data['type_id'],
            'currency_id'   => config('site.defaults.user.currency_id'),
            'price_type_id' => config('site.defaults.user.price_type_id'),
            'warehouse_id'  => config('site.defaults.user.warehouse_id'),
            'password'      => Hash::make($data['password']),
        ]);
    }

    public function confirm($token)
    {
        User::whereVerifyToken($token)->firstOrFail()->hasVerified();

        return redirect()->route('login')->with('success', trans('site::user.confirmed_email'));
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

}