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
     * @param  User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasPermission('addresses') && ($user->id > 0);
    }

    /**
     * @param User $user
     * @param Address $address
     * @return bool
     */
    public function phone(User $user, Address $address)
    {
        return $this->belongsUser($user, $address);
    }

    /**
     * @param  User $user
     * @param  Address $address
     * @return bool
     */
    public function edit(User $user, Address $address)
    {
        return $user->hasPermission('addresses') && $this->belongsUser($user, $address);
    }

    /**
     * @param  User $user
     * @param  Address $address
     * @return bool
     */
    public function delete(User $user, Address $address)
    {
        return ($user->getAttribute('admin') == 1 || $user->hasPermission('addresses')) && $address->addressable->addresses()->whereTypeId($address->type_id)->count() > 1;
    }


}
