<?php

namespace QuadStudio\Service\Site\Contracts;

use Illuminate\Database\Eloquent\Relations\morphMany;

interface Imageable
{
    /**
     * @return morphMany
     */
    function images();
}