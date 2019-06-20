<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\Contract;
use QuadStudio\Service\Site\Models\User;

class ContractPolicy
{
    /**
     * Determine whether the user can view the contract.
     *
     * @param User $user
     * @param Contract $contract
     * @return bool
     */
    public function view(User $user, Contract $contract)
    {
        return $user->hasPermission('contracts') && $this->belongsUser($user, $contract);
    }

    /**
     * Determine whether the user can update the address.
     *
     * @param  User $user
     * @param  Contract $contract
     * @return bool
     */
    public function edit(User $user, Contract $contract)
    {
        return $user->hasPermission('contracts') && $this->belongsUser($user, $contract);
    }

    private function belongsUser(User $user, Contract $contract)
    {
        return $user->id == $contract->contragent->getAttribute('user_id');
    }

    /**
     * Determine whether the user can create contracts.
     *
     * @param  User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasPermission('contracts') && ($user->id > 0);
    }

    /**
     * Determine whether the user can update the contract.
     *
     * @param  User $user
     * @param  Contract $contract
     * @return bool
     */
    public function update(User $user, Contract $contract)
    {
        return $user->hasPermission('contracts') && $this->belongsUser($user, $contract);
    }

    /**
     * Determine whether the user can delete the contract.
     *
     * @param  User $user
     * @param  Contract $contract
     * @return bool
     */
    public function delete(User $user, Contract $contract)
    {
        return $user->hasPermission('contracts') && $this->belongsUser($user, $contract);
    }

}
