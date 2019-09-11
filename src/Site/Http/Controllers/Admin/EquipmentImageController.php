<?php

namespace QuadStudio\Service\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use QuadStudio\Service\Site\Concerns\StoreImages;
use QuadStudio\Service\Site\Http\Requests\ImageRequest;
use QuadStudio\Service\Site\Models\Equipment;


class EquipmentImageController extends Controller
{

    use StoreImages;

    public function index(ImageRequest $request, Equipment $equipment)
    {
        $images = $this->getImages($request, $equipment);
        return view('site::admin.equipment.image.index', compact('equipment', 'images'));
    }

	/**
	 * @param \QuadStudio\Service\Site\Http\Requests\ImageRequest $request
	 * @param \QuadStudio\Service\Site\Models\Equipment $equipment
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Throwable
	 */
    public function store(ImageRequest $request, Equipment $equipment)
    {
        return $this->storeImages($request, $equipment);
    }

}