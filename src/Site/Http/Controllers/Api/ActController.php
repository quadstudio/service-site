<?php

namespace QuadStudio\Service\Site\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Http\Resources\ActResource;
use QuadStudio\Service\Site\Models\Act;

class ActController extends Controller
{

    /**
     * @param Act $act
     * @return ActResource
     */
    public function show(Act $act)
    {
        return new ActResource($act);
    }
}