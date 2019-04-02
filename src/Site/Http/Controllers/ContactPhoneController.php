<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Http\Requests\PhoneRequest;
use QuadStudio\Service\Site\Models\Contact;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Phone;

class ContactPhoneController extends Controller
{

    use AuthorizesRequests;

    /**
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function create(Contact $contact)
    {
        $this->authorize('create', Phone::class);
        $this->authorize('phone', $contact);
        $countries = Country::query()->where('enabled', 1)->orderBy('sort_order')->get();

        return view('site::contact.phone.create', compact('countries', 'contact'));
    }

    /**
     * @param PhoneRequest $request
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function store(PhoneRequest $request, Contact $contact)
    {
        $this->authorize('create', Phone::class);
        $this->authorize('phone', $contact);
        $contact->phones()->save(Phone::query()->create($request->input('phone')));

        return redirect()->route('contacts.show', $contact)->with('success', trans('site::phone.created'));
    }

    /**
     * @param Contact $contact
     * @param Phone $phone
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact, Phone $phone)
    {
        $this->authorize('edit', $phone);
        $this->authorize('phone', $contact);
        $countries = Country::query()->where('enabled', 1)->orderBy('sort_order')->get();

        return view('site::contact.phone.edit', compact('phone', 'contact', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PhoneRequest $request
     * @param Contact $contact
     * @param  Phone $phone
     * @return \Illuminate\Http\Response
     */
    public function update(PhoneRequest $request, Contact $contact, Phone $phone)
    {
        $this->authorize('edit', $phone);
        $this->authorize('phone', $contact);
        $phone->update($request->input('phone'));

        return redirect()->route('contacts.show', $phone->phoneable)->with('success', trans('site::phone.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @param Phone $phone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact, Phone $phone)
    {
        $this->authorize('delete', $phone);
        $this->authorize('phone', $contact);
        if ($phone->delete()) {
            Session::flash('success', trans('site::phone.deleted'));
        } else {
            Session::flash('error', trans('site::phone.error.deleted'));
        }
        $json['redirect'] = route('contacts.show', $contact);

        return response()->json($json);
    }

}