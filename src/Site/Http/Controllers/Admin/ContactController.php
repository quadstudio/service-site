<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Repositories\ContactRepository;
use QuadStudio\Service\Site\Models\Contact;

class ContactController extends Controller
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

        $this->contacts->trackFilter();
        return view('site::admin.contact.index', [
            'repository' => $this->contacts,
            'contacts'      => $this->contacts->paginate(config('site.per_page.contact', 10), ['contacts.*'])
        ]);
    }

    public function show(Contact $contact)
    {
        return view('site::contact.show', ['contact' => $contact]);
    }
}