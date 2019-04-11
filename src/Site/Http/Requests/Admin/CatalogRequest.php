<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CatalogRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
            case 'PUT':
            case 'PATCH': {
                return [
                    'catalog.catalog_id'      => 'sometimes|nullable|exists:catalogs,id',
                    'catalog.image_id'        => 'sometimes|nullable|exists:images,id',
                    'catalog.name'            => 'required|string|max:255',
                    'catalog.name_plural'     => 'max:255',
                    'catalog.h1'              => 'sometimes|nullable|max:255',
                    'catalog.title'           => 'sometimes|nullable|max:255',
                    'catalog.metadescription' => 'sometimes|nullable|max:255',
                ];
            }
            default:
                return [];
        }
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'catalog.catalog_id'      => trans('site::catalog.catalog_id'),
            'catalog.image_id'        => trans('site::catalog.image_id'),
            'catalog.name'            => trans('site::catalog.name'),
            'catalog.name_plural'     => trans('site::catalog.name_plural'),
            'catalog.h1'              => trans('site::catalog.h1'),
            'catalog.title'           => trans('site::catalog.title'),
            'catalog.metadescription' => trans('site::catalog.metadescription'),
        ];
    }
}
