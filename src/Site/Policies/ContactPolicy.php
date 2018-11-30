<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\Contact;
use QuadStudio\Service\Site\Models\User;

class ContactPolicy
{

    public function index(User $user)
    {
        return $user->hasPermission('contacts');
    }

    /**
     * Determine whether the user can view the contact.
     *
     * @param User $user
     * @param Contact $contact
     * @return bool
     */
    public function view(User $user, Contact $contact)
    {
        return $user->hasPermission('contacts') && $this->belongsUser($user, $contact);
    }

    /**
     * Determine whether the user can update the address.
     *
     * @param  User $user
     * @param  Contact $contact
     * @return bool
     */
    public function edit(User $user, Contact $contact)
    {
        return $user->hasPermission('contacts') && $this->belongsUser($user, $contact);
    }

    private function belongsUser(User $user, Contact $contact)
    {
        return $user->id == $contact->getAttribute('user_id');
    }

    /**
     * Determine whether the user can create contacts.
     *
     * @param  User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasPermission('contacts') && ($user->id > 0);
    }

    /**
     * Determine whether the user can update the contact.
     *
     * @param  User $user
     * @param  Contact $contact
     * @return bool
     */
    public function update(User $user, Contact $contact)
    {
        return $user->hasPermission('contacts') && $this->belongsUser($user, $contact);
    }

    /**
     * Determine whether the user can delete the contact.
     *
     * @param  User $user
     * @param  Contact $contact
     * @return bool
     */
    public function delete(User $user, Contact $contact)
    {
        return $user->hasPermission('contacts') && $this->belongsUser($user, $contact) && in_array($contact->getAttribute('type_id'), [2,3,4]);
    }

}
