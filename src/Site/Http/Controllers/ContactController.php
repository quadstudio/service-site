<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use QuadStudio\Service\Site\Filters\BelongsUserFilter;
use QuadStudio\Service\Site\Http\Requests\ContactRequest;
use QuadStudio\Service\Site\Models\Contact;
use QuadStudio\Service\Site\Models\ContactType;
use QuadStudio\Service\Site\Models\Country;
use QuadStudio\Service\Site\Models\Phone;
use QuadStudio\Service\Site\Repositories\ContactRepository;

class ContactController extends Controller
{

    use AuthorizesRequests;

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
            'contacts'   => $this->contacts->paginate(config('site.per_page.contact', 10), ['contacts.*'])
        ]);
    }

    /**
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        $this->authorize('view', $contact);

        return view('site::contact.show', compact('contact'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = ContactType::query()->where('enabled', 1)->get();
        $countries = Country::query()->where('enabled', 1)->orderBy('sort_order')->get();

        return view('site::contact.create', compact('types', 'countries'));
    }

    /**
     * @param ContactRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        /** @var $contact Contact */
        $request->user()->contacts()->save($contact = Contact::query()->create($request->input('contact')));
        $contact->phones()->save(Phone::query()->create($request->input('phone')));

        return redirect()->route('contacts.show', $contact)->with('success', trans('site::contact.created'));
    }

    /**
     * @param  Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        $this->authorize('edit', $contact);
        $types = ContactType::all();
        $countries = Country::query()->where('enabled', 1)->orderBy('sort_order')->get();
        $phones = $contact->phones;

        return view('site::contact.edit', compact('types', 'contact', 'countries', 'phones'));
    }

    /**
     * @param  ContactRequest $request
     * @param  Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        $this->authorize('update', $contact);
        $contact->update($request->input(['contact']));

        return redirect()->route('contacts.show', $contact)->with('success', trans('site::contact.updated'));
    }

    /**
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {

        $this->authorize('delete', $contact);
        if ($contact->delete()) {
            Session::flash('success', trans('site::contact.deleted'));
        } else {
            Session::flash('error', trans('site::contact.error.deleted'));
        }
        $json['redirect'] = route('contacts.index');

        return response()->json($json);
    }

}