<?php

namespace QuadStudio\Service\Site\Contracts;

use QuadStudio\Service\Site\Models\User;

interface Messagable
{
    /**
     * @return string
     */
    function messageSubject();

    /**
     * @return \Illuminate\Routing\Route
     */
    function messageRoute();

    /**
     * @return \Illuminate\Routing\Route
     */
    function messageMailRoute();

    /**
     * @return \Illuminate\Routing\Route
     */
    function messageStoreRoute();

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    function messages();

    /** @return User */
    function messageReceiver();
}