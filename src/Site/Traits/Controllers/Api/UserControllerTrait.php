<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;

use QuadStudio\Service\Site\Http\Resources\UserCollection;
use QuadStudio\Service\Site\Http\Resources\UserResource;
use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Site\Repositories\UserRepository;

trait UserControllerTrait
{
    protected $users;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Show the user profile
     */
    public function index()
    {
        //return new UserCollection($this->users->all());
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }
}