<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Http\Requests\PhoneRequest;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Phone;
use QuadStudio\Service\Site\Repositories\PhoneRepository;

trait PhoneControllerTrait
{

    protected $phones;

    /**
     * Create a new controller instance.
     *
     * @param PhoneRepository $phones
     */
    public function __construct(PhoneRepository $phones)
    {
        $this->phones = $phones;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {
//        $this->authorize('index', Phone::class);
//        $this->phones->trackFilter();
//        $this->phones->applyFilter((new PhoneableFilter())->setId(Auth::user()->getAuthIdentifier())->setMorph('users'));
//
//        return view('site::phone.index', [
//            'repository' => $this->phones,
//            'phones'  => $this->phones->paginate(config('site.per_page.phone', 10), ['phones.*'])
//        ]);
//    }

//    public function create()
//    {
//        
//        $countries = Country::enabled()->orderBy('sort_order')->get();
//        return view('site::phone.create', compact('countries'));
//    }
//
//    public function store(PhoneRequest $request)
//    {
//        /** @var $phone Phone */
//        $request->user()->phones()->save($phone = Phone::create($request->input('phone')));
//        $phone->phones()->save(Phone::create($request->input('phone')));
//
//        return redirect()->route('phones.index')->with('success', trans('site::phone.created'));
//    }

    /**
     * @param Phone $phone
     * @return \Illuminate\Http\Response
     */
    public function edit(Phone $phone)
    {
        $this->authorize('edit', $phone);

        $countries = Country::enabled()->orderBy('sort_order')->get();

        return view('site::phone.edit', compact('phone', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PhoneRequest $request
     * @param  Phone $phone
     * @return \Illuminate\Http\Response
     */
    public function update(PhoneRequest $request, Phone $phone)
    {
        $phone->update($request->except(['_token', '_method']));
        if ($phone->phoneable_type == 'addresses') {
            $route = 'addresses.index';
        } elseif ($phone->phoneable_type == 'contacts') {
            $route = 'contacts.index';
        } else {
            $route = 'home';
        }

        return redirect()->route($route)->with('success', trans('site::phone.updated'));
    }

    public function destroy(Phone $phone)
    {
        $this->authorize('delete', $phone);

        if ($phone->delete()) {
            $json['remove'][] = '#phone-' . $phone->id;
        } else {
            $json['error'][] = 'error';
        }

        return response()->json($json);
    }

}