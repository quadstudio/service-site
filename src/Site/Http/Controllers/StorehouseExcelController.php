<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use QuadStudio\Service\Site\Http\Requests\StorehouseExcelRequest;
use QuadStudio\Service\Site\Imports\Excel\StorehouseExcel;
use QuadStudio\Service\Site\Models\Storehouse;

class StorehouseExcelController extends Controller
{

    use AuthorizesRequests;

    /**
     * @param StorehouseExcelRequest $request
     * @param Storehouse $storehouse
     * @return \Illuminate\Http\Response
     */
    public function store(StorehouseExcelRequest $request, Storehouse $storehouse)
    {
        abort(404);
        $this->authorize('view', $storehouse);

        $data = (new StorehouseExcel())->get($request);
        $storehouse->products()->delete();
        $storehouse->products()->createMany($data);
        $storehouse->update(['uploaded_at' => date('d.m.Y H:i:s')]);

        return redirect()->route('storehouses.show', $storehouse)->with('success', trans('site::storehouse_product.loaded'));

    }

}