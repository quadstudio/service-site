<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Http\Requests\Admin\AuthorizationTypeRequest;
use QuadStudio\Service\Site\Models\AuthorizationBrand;
use QuadStudio\Service\Site\Models\AuthorizationType;
use QuadStudio\Service\Site\Repositories\AuthorizationTypeRepository;

class AuthorizationTypeController extends Controller
{
    /**
     * @var AuthorizationTypeRepository
     */
    protected $authorization_types;

    /**
     * Create a new controller instance.
     *
     * @param AuthorizationTypeRepository $authorization_types
     */
    public function __construct(AuthorizationTypeRepository $authorization_types)
    {
        $this->authorization_types = $authorization_types;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorization_types->trackFilter();

        return view('site::admin.authorization_type.index', [
            'repository'          => $this->authorization_types,
            'authorization_types' => $this->authorization_types->paginate(config('site.per_page.authorization_type', 10), ['authorization_types.*'])
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authorization_brands = AuthorizationBrand::get();

        return view('site::admin.authorization_type.create', compact('authorization_brands'));
    }

    /**
     * @param  AuthorizationTypeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorizationTypeRequest $request)
    {

        $this->authorization_types->create(array_merge(
            $request->input(['authorization_type']),
            ['enabled' => $request->filled('authorization_type.enabled') ? 1 : 0]
        ));

        return redirect()->route('admin.authorization-types.index')->with('success', trans('site::authorization_type.created'));
    }

    /**
     * @param AuthorizationType $authorization_type
     * @return \Illuminate\Http\Response
     */
    public function edit(AuthorizationType $authorization_type)
    {
        $authorization_brands = AuthorizationBrand::get();

        return view('site::admin.authorization_type.edit', compact('authorization_type', 'authorization_brands', 'address_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AuthorizationTypeRequest $request
     * @param  AuthorizationType $authorization_type
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorizationTypeRequest $request, AuthorizationType $authorization_type)
    {

        $authorization_type->update(array_merge(
            $request->input(['authorization_type']),
            ['enabled' => $request->filled('authorization_type.enabled') ? 1 : 0]
        ));

        return redirect()->route('admin.authorization-types.index')->with('success', trans('site::authorization_type.updated'));
    }

}