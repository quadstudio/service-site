<?php

namespace QuadStudio\Service\Site\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use QuadStudio\Service\Site\Http\Requests\StorehouseExcelRequest;
use QuadStudio\Service\Site\Models\Storehouse;

class StorehouseExcelController extends Controller
{

    use AuthorizesRequests;

	/**
	 * @param StorehouseExcelRequest $request
	 * @param Storehouse $storehouse
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
	 */
    public function store(StorehouseExcelRequest $request, Storehouse $storehouse)
    {
        $this->authorize('view', $storehouse);
	    $storehouse->updateFromExcel($request->path);


        return redirect()->route('storehouses.show', $storehouse)->with('success', trans('site::storehouse_product.loaded'));

    }

}