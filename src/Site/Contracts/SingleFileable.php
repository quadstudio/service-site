<?php

namespace QuadStudio\Service\Site\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface SingleFileable
{
    /**
     * @return BelongsTo
     */
    function file();
}