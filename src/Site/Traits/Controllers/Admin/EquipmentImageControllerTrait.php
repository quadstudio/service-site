<?php

namespace QuadStudio\Service\Site\Traits\Controllers\Admin;

use Illuminate\Http\Request;
use QuadStudio\Service\Site\Http\Requests\ImageRequest;
use QuadStudio\Service\Site\Models\Equipment;
use QuadStudio\Service\Site\Models\Image;
use QuadStudio\Service\Site\Traits\Support\ImageLoaderTrait;


trait EquipmentImageControllerTrait
{

    use ImageLoaderTrait;

    public function edit(Request $request, Equipment $equipment)
    {
        $images = $this->getImages($request, $equipment);

        return view('site::admin.equipment.image.edit', compact('equipment', 'images'));
    }

    /**
     * @param ImageRequest $request
     * @param Equipment $equipment
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ImageRequest $request, Equipment $equipment)
    {
        $image =  $this->createImage($request);
        $equipment->images()->save($image);
        //\Illuminate\Http\Response
        $result = [
            'append' => [
                '#sort-list' => view('site::admin.image.edit', compact('image'))->render()
            ]
        ];

        return response()->json($result);
    }

    public function update(Request $request, Equipment $equipment)
    {
        $this->setImages($request, $equipment);

        return redirect()->route('admin.equipments.images.edit', $equipment)->with('success', trans('site::image.updated'));
    }

    public function destroy(Request $request, Equipment $equipment)
    {
        if($request->filled('images')){
            Image::query()->whereIn('id', $request->input('images'))->delete();
            return redirect()->route('admin.equipments.images.edit', $equipment)->with('success', trans('site::image.deleted'));
        } else{
            return redirect()->route('admin.equipments.images.edit', $equipment)->with('warning', trans('site::image.not_selected'));
        }


    }

    /**
     * @param Request $request
     * @param Equipment $equipment
     */
    public function sort(Request $request, Equipment $equipment)
    {
        $sort = array_flip($request->input('sort'));
        /** @var Image $image */
        foreach ($equipment->images()->get() as $image) {
            $image->setAttribute('sort_order', $sort[$image->getKey()]);
            $image->save();
        }
    }

}