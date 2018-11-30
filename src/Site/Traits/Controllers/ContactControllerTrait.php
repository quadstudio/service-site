<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Http\Requests\ContactRequest;
use QuadStudio\Service\Site\Models\Contact;
use QuadStudio\Service\Site\Models\ContactType;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Phone;
use QuadStudio\Service\Site\Repositories\ContactRepository;

trait ContactControllerTrait
{

    protected $contacts;

    /**
     * Create a new controller instance.
     *
     * @param ContactRepository $contacts
     */
    public function __construct(ContactRepository $contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Contact::class);
        $this->contacts->trackFilter();
        $this->contacts->applyFilter(new BelongsUserFilter());
        return view('site::contact.index', [
            'repository' => $this->contacts,
            'contacts'      => $this->contacts->paginate(config('site.per_page.contact', 10), ['contacts.*'])
        ]);
    }

    public function create()
    {
        $types = ContactType::find([2,3,4]);
        $countries = Country::enabled()->orderBy('sort_order')->get();
        return view('site::contact.create', compact('types', 'countries'));
    }

    public function store(ContactRequest $request)
    {
        /** @var $contact Contact */
        $request->user()->contacts()->save($contact = Contact::create($request->input('contact')));
        $contact->phones()->save(Phone::create($request->input('phone')));

        return redirect()->route('contacts.index')->with('success', trans('site::contact.created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        $this->authorize('edit', $contact);
        $types = ContactType::all();

        return view('site::contact.edit', compact('types', 'contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ContactRequest $request
     * @param  Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $this->authorize('update', $contact);
        $contact->update($request->input(['contact']));

        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('contacts.edit', $contact)->with('success', trans('site::contact.updated'));
        } else {
            $redirect = redirect()->route('contacts.index')->with('success', trans('site::contact.updated'));
        }

        return $redirect;
    }

    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);
        $contact->phones()->delete();
        if ($contact->delete()) {
            $json['remove'][] = '#contact-' . $contact->id;
        } else {
            $json['error'][] = 'error';
        }

        return response()->json($json);
    }

}