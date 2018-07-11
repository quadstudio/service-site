<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Auth;


use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use QuadStudio\Service\Site\Http\Requests\Register as Request;
use QuadStudio\Service\Site\Mail\ConfirmationEmail;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\Contact;
use QuadStudio\Service\Site\Models\Contragent;
use QuadStudio\Service\Site\Models\ContragentType;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Phone;
use QuadStudio\Service\Site\Models\Service;
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
        $types = ContragentType::all();

        return view('site::auth.register', compact('countries', 'types'));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        event(new Registered($user = $this->createUser($request->all())));
        /** @var $contact Contact */
        $user->contacts()->save($contact = Contact::create($request->input('contact')));
        $contact->phones()->save(Phone::create($request->input('phone.contact')));
        $user->addresses()->save(Address::create($request->input('address.user')));
        /** @var $contragent Contragent */
        $user->contragents()->save($contragent = Contragent::create($request->input('contragent')));
        $contragent->addresses()->saveMany([
            Address::create($request->input('address.legal')),
            Address::create($request->input('address.postal')),
        ]);
        $user->attachRole(config('site.defaults.user.role_id', 2));
        Mail::to($user->getEmailForPasswordReset())->send(new ConfirmationEmail($user));

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
            'name'     => $data['name'],
            'email'    => $data['email'],
            'sc'       => $data['sc'],
            'web'      => $data['web'],
            'password' => Hash::make($data['password']),
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