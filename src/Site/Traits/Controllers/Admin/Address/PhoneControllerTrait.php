<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin\Address;


//use QuadStudio\Service\Site\Filters\PhoneableFilter;
use QuadStudio\Service\Site\Http\Requests\PhoneRequest;
use QuadStudio\Service\Site\Models\Phone;
use QuadStudio\Service\Site\Models\Country;

use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Repositories\PhoneRepository;

trait PhoneControllerTrait
{
    /**
     * @var PhoneRepository
     */
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
     * Показать список адресов сервисного центра
     *
     * @param Address $address
     * @return \Illuminate\Http\Response
     */
    public function index(Address $address)
    {
        $this->phones->trackFilter();
        //$this->phones->applyFilter((new PhoneableFilter())->setId($address->getKey())->setMorph($address->path()));

        return view('site::admin.address.phone.index', [
            'address'       => $address,
            'repository' => $this->phones,
            'phones'  => $this->phones->paginate(config('site.per_page.phone', 10), ['phones.*'])
        ]);
    }

    /**
     * @param Address $address
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Address $address)
    {

        $countries = Country::enabled()->orderBy('sort_order')->get();
        return view('site::admin.address.phone.create', compact('address', 'countries'));
    }

//    /**
//     * @param PhoneRequest $request
//     * @param Address $address
//     * @return \Illuminate\Http\RedirectResponse
//     */
    public function store(PhoneRequest $request, Address $address)
    {
        /** @var $phone Phone */
        $address->phones()->create($request->except('_token'));

        return redirect()->route('admin.addresses.show', $address)->with('success', trans('site::phone.created'));
    }

}