<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use QuadStudio\Service\Site\Http\Requests\Admin\UserPasswordRequest;
use QuadStudio\Service\Site\Models\User;

class UserPasswordController extends Controller
{

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(User $user)
    {
        return view('site::admin.user.password', compact('user'));
    }

    /**
     * @param UserPasswordRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserPasswordRequest $request, User $user)
    {

        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('admin.users.show', $user)->with('success', trans('site::user.password_updated'));
    }

}