<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Http\Requests\Admin\AuthorizationBrandRequest;
use QuadStudio\Service\Site\Models\AuthorizationBrand;
use QuadStudio\Service\Site\Repositories\AuthorizationBrandRepository;

class AuthorizationBrandController extends Controller
{

    protected $authorization_brands;

    /**
     * Create a new controller instance.
     *
     * @param AuthorizationBrandRepository $authorization_brands
     */
    public function __construct(AuthorizationBrandRepository $authorization_brands)
    {
        $this->authorization_brands = $authorization_brands;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorization_brands->trackFilter();

        return view('site::admin.authorization_brand.index', [
            'repository'           => $this->authorization_brands,
            'authorization_brands' => $this->authorization_brands->paginate(config('site.per_page.authorization_brand', 10), ['authorization_brands.*'])
        ]);
    }

    /**
     * @param AuthorizationBrand $authorization_brand
     * @return \Illuminate\Http\Response
     */
    public function edit(AuthorizationBrand $authorization_brand)
    {
        return view('site::admin.authorization_brand.edit', compact('authorization_brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AuthorizationBrandRequest $request
     * @param  AuthorizationBrand $authorization_brand
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorizationBrandRequest $request, AuthorizationBrand $authorization_brand)
    {
        $authorization_brand->update($request->input(['authorization_brand']));

        return redirect()->route('admin.authorization-brands.index')->with('success', trans('site::authorization_brand.updated'));
    }

    public function create()
    {
        return view('site::admin.authorization_brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AuthorizationBrandRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorizationBrandRequest $request)
    {

        $this->authorization_brands->create($request->input(['authorization_brand']));

        return redirect()->route('admin.authorization-brands.index')->with('success', trans('site::authorization_brand.created'));
    }
}