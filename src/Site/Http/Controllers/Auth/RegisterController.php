<?php

namespace QuadStudio\Service\Site\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use QuadStudio\Service\Site\Http\Requests\RegisterRequest;
use QuadStudio\Service\Site\Http\Requests\RegisterFlRequest;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\Contact;
use QuadStudio\Service\Site\Models\Contragent;
use QuadStudio\Service\Site\Models\ContragentType;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Phone;
use QuadStudio\Service\Site\Models\Region;
use QuadStudio\Service\Site\Models\User;

class RegisterController extends Controller
{

    use RegistersUsers;

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

        $countries = Country::query()->where('id', config('site.country'))->get();
        $address_legal_regions = Region::where('country_id', config('site.country'))->orderBy('name')->get();
        $address_postal_regions = Region::where('country_id', config('site.country'))->orderBy('name')->get();
        $types = ContragentType::all();

        return view('site::auth.register', compact('countries', 'types', 'address_legal_regions', 'address_postal_regions'));
    }
	
	/**
	* Регистрация физических лиц без контрагентов
	*/
	public function showRegistrationFlForm()
    {
        $countries = Country::query()->where('id', config('site.country'))->get();
        $address_sc_regions = Region::where('country_id', config('site.country'))->orderBy('name')->get();
        
        return view('site::auth.register_fl', compact('countries', 'address_sc_regions'));
    }


    public function register(RegisterRequest $request)
    {
        $user = $this->createUser($request->all());
        $user->contacts()->save($contact = Contact::query()->create($request->input('contact')));
        $contact->phones()->save(Phone::query()->create($request->input('phone.contact')));

        /** @var $contragent Contragent */
        $user->contragents()->save($contragent = Contragent::query()->create($request->input('contragent')));

        $legal = Address::query()->create($request->input('address.legal'));
        if (!$request->filled('legal')) {
            $postal = Address::query()->create($request->input('address.postal'));
        } else{
            $postal = Address::query()->create(array_merge($request->input('address.legal'), ['type_id' => 3]));
        }

        $contragent->addresses()->saveMany([$legal, $postal]);

        $user->attachRole(config('site.defaults.user.role_id', 2));
        $user->update(['region_id' => $legal->getAttribute('region_id')]);

        event(new Registered($user));

        return redirect()->route('login')->with('success', trans('site::user.confirm_email', ['email' => $user->getEmailForPasswordReset()]));

    }
	public function register_fl(RegisterFlRequest $request)
    {
        $user = $this->createUser($request->all());
        /** @var $contact Contact */
        $user->contacts()->save($contact = Contact::query()->create($request->input('contact')));
        $contact->phones()->save(Phone::query()->create($request->input('phone.contact')));
		$user->addresses()->save($address = Address::create($request->input('address.sc')));
        /** @var $contragent Contragent */
        $user->attachRole('14');
        $user->update(['region_id' => $request->input('address.sc.region_id'), 'type_id' => '3']);

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