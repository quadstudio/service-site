<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            case 'GET':
            case 'DELETE':
            case 'POST': {
                return [];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'name'     => 'required|string|max:255',
                    'sku'      => 'max:255',
                    'old_sku'  => 'max:255',
                    'type_id'  => 'required|exists:product_types,id',
                    'enabled'  => 'required|boolean',
                    'active'   => 'required|boolean',
                    'warranty' => 'required|boolean',
                    'service'  => 'required|boolean',
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
            'name'     => trans('site::product.name'),
            'sku'      => trans('site::product.sku'),
            'old_sku'  => trans('site::product.old_sku'),
            'type_id'  => trans('site::product.type_id'),
            'enabled'  => trans('site::product.enabled'),
            'active'   => trans('site::product.active'),
            'warranty' => trans('site::product.warranty'),
            'service'  => trans('site::product.service'),
        ];
    }
}
