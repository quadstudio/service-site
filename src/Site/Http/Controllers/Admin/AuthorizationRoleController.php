<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use QuadStudio\Rbac\Models\Role;
use QuadStudio\Service\Site\Http\Requests\Admin\AuthorizationRoleRequest;
use QuadStudio\Service\Site\Models\AddressType;
use QuadStudio\Service\Site\Models\AuthorizationRole;
use QuadStudio\Service\Site\Repositories\AuthorizationRoleRepository;

class AuthorizationRoleController extends Controller
{

    use AuthorizesRequests, ValidatesRequests;

    protected $authorization_roles;

    /**
     * Create a new controller instance.
     *
     * @param AuthorizationRoleRepository $authorization_roles
     */
    public function __construct(AuthorizationRoleRepository $authorization_roles)
    {
        $this->authorization_roles = $authorization_roles;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authorization_roles = $this->authorization_roles->all();
        $roles = Role::query()->orderBy('title')->get();

        return view('site::admin.authorization_role.index', compact('authorization_roles', 'roles'));
    }

    public function create(Role $role)
    {
        $address_types = AddressType::get();
        return view('site::admin.authorization_role.create', compact('role', 'address_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AuthorizationRoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorizationRoleRequest $request)
    {

        $this->authorization_roles->create($request->input(['authorization_role']));

        return redirect()->route('admin.authorization-roles.index')->with('success', trans('site::authorization_role.created'));
    }
    /**
     * @param AuthorizationRole $authorization_role
     * @return \Illuminate\Http\Response
     */
    public function edit(AuthorizationRole $authorization_role)
    {
        $address_types = AddressType::get();
        return view('site::admin.authorization_role.edit', compact('authorization_role', 'address_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AuthorizationRoleRequest $request
     * @param  AuthorizationRole $authorization_role
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorizationRoleRequest $request, AuthorizationRole $authorization_role)
    {
        $authorization_role->update($request->input(['authorization_role']));

        return redirect()->route('admin.authorization-roles.index')->with('success', trans('site::authorization_role.updated'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  AuthorizationRole $authorization_role
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuthorizationRole $authorization_role)
    {

        if ($authorization_role->delete()) {
            return redirect()->route('admin.authorization-roles.index')->with('success', trans('site::authorization_role.deleted'));
        } else {
            return redirect()->route('admin.authorization-roles.index')->with('error', trans('site::authorization_role.error.deleted'));
        }

    }
}