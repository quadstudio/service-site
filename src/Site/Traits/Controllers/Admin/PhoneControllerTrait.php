<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Http\Requests\PhoneRequest;
use QuadStudio\Service\Site\Models\Phone;
use QuadStudio\Service\Site\Models\Country;
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
    public function index()
    {

        $this->phones->trackFilter();
        return view('site::admin.phone.index', [
            'repository' => $this->phones,
            'phones'  => $this->phones->paginate(config('site.per_page.phone', 10), ['phones.*'])
        ]);
    }

    /**
     * @param Phone $phone
     * @return \Illuminate\Http\Response
     */
    public function edit(Phone $phone)
    {
        $countries = Country::enabled()->orderBy('sort_order')->get();
        return view('site::admin.phone.edit', compact('phone', 'countries'));
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
        $phone->update($request->except(['_token']));
        if($phone->phoneable_type == 'addresses'){
            return redirect()->route('admin.addresses.show', $phone->phoneable)->with('success', trans('site::phone.updated'));
        } else{
            dd('В РАЗРВБОТКЕ');
            return redirect()->route('admin.phones.show', $phone)->with('success', trans('site::phone.updated'));
        }

    }

    public function destroy(Phone $phone)
    {
        if ($phone->delete()) {
            $json['remove'][] = '#phone-' . $phone->id;
        } else {
            $json['error'][] = 'error';
        }

        return response()->json($json);
    }

}