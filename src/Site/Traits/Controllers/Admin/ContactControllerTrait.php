<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Service\Site\Repositories\ContactRepository;
use QuadStudio\Service\Site\Models\Contact;

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

        $this->contacts->trackFilter();
        return view('site::contact.index', [
            'repository' => $this->contacts,
            'items'      => $this->contacts->paginate(config('site.per_page.contact', 10), [env('DB_PREFIX', '').'contacts.*'])
        ]);
    }

    public function show(Contact $contact)
    {
        return view('site::contact.show', ['contact' => $contact]);
    }
}