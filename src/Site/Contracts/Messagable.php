<?php

namespace QuadStudio\Service\Site\Contracts;

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
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    function messages();
}