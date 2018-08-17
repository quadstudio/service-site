<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\Address;
use QuadStudio\Service\Site\Models\User;

class AddressPolicy
{

    public function index(User $user)
    {
        return $user->hasPermission('addresses');
    }

    /**
     * Determine whether the user can view the address.
     *
     * @param User $user
     * @param Address $address
     * @return bool
     */
    public function view(User $user, Address $address)
    {
        return $user->hasPermission('addresses') && $this->belongsUser($user, $address);
    }

    private function belongsUser(User $user, Address $address){
        return $user->id == ($address->addressable_type == 'users' ? $address->addressable->id : $address->addressable->user_id);
    }

    /**
     * Determine whether the user can create addresses.
     *
     * @param  User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasPermission('addresses') && ($user->id > 0);
    }

    /**
     * Determine whether the user can update the address.
     *
     * @param  User $user
     * @param  Address $address
     * @return bool
     */
    public function edit(User $user, Address $address)
    {
        return $user->hasPermission('addresses') && $this->belongsUser($user, $address);
    }

    /**
     * Determine whether the user can delete the address.
     *
     * @param  User $user
     * @param  Address $address
     * @return bool
     */
    public function delete(User $user, Address $address)
    {
        //return $user->hasPermission('addresses') && ($user->id == $address->addressable->user_id);
        return false;
    }


}
