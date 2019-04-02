<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Http\Requests\PhoneRequest;
use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Phone;

class AddressPhoneController extends Controller
{

    use AuthorizesRequests;

    /**
     * @param Address $address
     * @return \Illuminate\Http\Response
     */
    public function create(Address $address)
    {
        $this->authorize('create', Phone::class);
        $this->authorize('phone', $address);
        $countries = Country::query()->where('enabled', 1)->orderBy('sort_order')->get();

        return view('site::address.phone.create', compact('countries', 'address'));
    }

    /**
     * @param PhoneRequest $request
     * @param Address $address
     * @return \Illuminate\Http\Response
     */
    public function store(PhoneRequest $request, Address $address)
    {
        $this->authorize('create', Phone::class);
        $this->authorize('phone', $address);
        $address->phones()->save(Phone::query()->create($request->input('phone')));

        return redirect()->route('addresses.show', $address)->with('success', trans('site::phone.created'));
    }

    /**
     * @param Address $address
     * @param Phone $phone
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address, Phone $phone)
    {
        $this->authorize('edit', $phone);
        $this->authorize('phone', $address);
        $countries = Country::query()->where('enabled', 1)->orderBy('sort_order')->get();

        return view('site::address.phone.edit', compact('phone', 'address', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PhoneRequest $request
     * @param Address $address
     * @param  Phone $phone
     * @return \Illuminate\Http\Response
     */
    public function update(PhoneRequest $request, Address $address, Phone $phone)
    {
        $this->authorize('edit', $phone);
        $this->authorize('phone', $address);
        $phone->update($request->input('phone'));

        return redirect()->route('addresses.show', $phone->phoneable)->with('success', trans('site::phone.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Address $address
     * @param Phone $phone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address, Phone $phone)
    {
        $this->authorize('delete', $phone);
        $this->authorize('phone', $address);
        if ($phone->delete()) {
            Session::flash('success', trans('site::phone.deleted'));
        } else {
            Session::flash('error', trans('site::phone.error.deleted'));
        }
        $json['redirect'] = route('addresses.show', $address);

        return response()->json($json);
    }

}