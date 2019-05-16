<?php

namespace QuadStudio\Service\Site\Contracts;

use Illuminate\Database\Eloquent\Relations\morphMany;

interface Fileable
{
    /**
     * @return morphMany
     */
    function files();
}