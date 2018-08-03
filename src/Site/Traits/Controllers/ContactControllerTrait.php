<?php

namespace QuadStudio\Service\Site\Traits\Controllers;

use QuadStudio\Service\Site\Filters\BelongsUserFilter;
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

        $this->contacts->trackFilter();
        $this->contacts->applyFilter(new BelongsUserFilter());
        return view('site::contact.index', [
            'repository' => $this->contacts,
            'contacts'      => $this->contacts->paginate(config('site.per_page.contact', 10), [env('DB_PREFIX', '') . 'contacts.*'])
        ]);
    }

}