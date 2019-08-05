<?php

namespace QuadStudio\Service\Site\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Models\Storehouse;

class StorehouseController extends Controller
{
    public function automatic()
    {

        foreach (Storehouse::needAutomaticUpdate()->limit(1)->get() as $storehouse) {
            $storehouse->updateFromUrl();
            return redirect()->route('api.storehouses.automatic');
        }
        return null;

    }

}
