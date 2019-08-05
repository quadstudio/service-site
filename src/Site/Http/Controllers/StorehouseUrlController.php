<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use QuadStudio\Service\Site\Http\Requests\StorehouseUrlRequest;
use QuadStudio\Service\Site\Imports\Excel\StorehouseUrl;
use QuadStudio\Service\Site\Models\Storehouse;

class StorehouseUrlController extends Controller
{

    use AuthorizesRequests;


    /**
     * @param StorehouseUrlRequest $request
     * @param Storehouse $storehouse
     * @return \Illuminate\Http\Response
     */
    public function store(StorehouseUrlRequest $request, Storehouse $storehouse)
    {
        abort(404);
        $this->authorize('view', $storehouse);
        $storehouse->updateFromUrl();

        return redirect()->route('storehouses.show', $storehouse)->with('success', trans('site::storehouse_product.loaded'));

    }

}