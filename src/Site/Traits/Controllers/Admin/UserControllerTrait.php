<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use QuadStudio\Rbac\Repositories\RoleRepository;
use QuadStudio\Service\Site\Events\UserExport;
use QuadStudio\Service\Site\Filters\UserIsServiceFilter;
use QuadStudio\Service\Site\Http\Requests\Admin\UserRequest;
use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Repositories\PriceTypeRepository;
use QuadStudio\Service\Site\Repositories\UserRepository;
use QuadStudio\Service\Site\Repositories\WarehouseRepository;

trait UserControllerTrait
{
    protected $users;
    protected $types;
    protected $roles;
    protected $warehouses;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository $users
     * @param PriceTypeRepository $types
     * @param RoleRepository $roles
     * @param WarehouseRepository $warehouses
     */
    public function __construct(
        UserRepository $users,
        PriceTypeRepository $types,
        RoleRepository $roles,
        WarehouseRepository $warehouses
    )
    {
        $this->users = $users;
        $this->types = $types;
        $this->roles = $roles;
        $this->warehouses = $warehouses;
    }

    /**
     * Show the user profile
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->users->trackFilter();
        $this->users->applyFilter(new UserIsServiceFilter);
        return view('site::admin.user.index', [
            'repository' => $this->users,
            'users'      => $this->users->paginate(config('site.per_page.user', 10), [env('DB_PREFIX', '') . 'users.*'])
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('site::admin.user.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $types = $this->types->all();
        $roles = $this->roles->all();
        $warehouses = $this->warehouses->all();
        return view('site::admin.user.edit', compact('user', 'types', 'roles', 'warehouses'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function export(User $user){
        if($user->can_export()){
            event(new UserExport($user));
            $redirect = redirect()->route('admin.users.show', $user)->with('success', trans('site::user.success.export'));
        } else{
            $redirect = redirect()->route('admin.users.show', $user)->with('error', trans('site::user.error.export'));
        }
        return $redirect;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $this->users->update($request->input('user'), $user->id);
        $user->syncRoles($request->input('roles', []));
        if ($request->input('_stay') == 1) {
            $redirect = redirect()->route('admin.users.edit', $user)->with('success', trans('site::user.updated'));
        } else {
            $redirect = redirect()->route('admin.users.show', $user)->with('success', trans('site::user.updated'));
        }

        return $redirect;
    }
}