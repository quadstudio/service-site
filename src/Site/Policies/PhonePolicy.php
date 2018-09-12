<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\Phone;
use QuadStudio\Service\Site\Models\User;

class PhonePolicy
{


    /**
     * Determine whether the user can view the phone.
     *
     * @param User $user
     * @param Phone $phone
     * @return bool
     */
    public function view(User $user, Phone $phone)
    {
        return $user->hasPermission('phones') && $this->belongsUser($user, $phone);
    }

    private function belongsUser(User $user, Phone $phone){
        return $user->hasPermission('phones') && ($phone->phoneable_type == 'addresses' ? ($phone->phoneable->addressable_type == 'contragents' ? $phone->phoneable->addressable->user_id : $phone->phoneable->addressable->id) : $phone->phoneable->user_id);
    }

    /**
     * Determine whether the user can create phones.
     *
     * @param  User $user
     * @return bool
     */
    public function create(User $user)
    {
        return ($user->id > 0);
    }

    /**
     * Determine whether the user can update the phone.
     *
     * @param  User $user
     * @param  Phone $phone
     * @return bool
     */
    public function edit(User $user, Phone $phone)
    {
        return $user->hasPermission('phones') && $this->belongsUser($user, $phone);
    }

    /**
     * Determine whether the user can delete the phone.
     *
     * @param  User $user
     * @param  Phone $phone
     * @return bool
     */
    public function delete(User $user, Phone $phone)
    {
        return $user->hasPermission('phones') && $phone->phoneable->phones()->count() > 1;
    }


}
