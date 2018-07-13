<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Api;


use QuadStudio\Service\Site\Http\Resources\SerialResource;
use QuadStudio\Service\Site\Models\Serial;

trait SerialControllerTrait
{

    public function show($serial)
    {
        return ($_ = Serial::find($serial)) ? new SerialResource($_)  : response('', 404);
    }
}