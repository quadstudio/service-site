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
            case 'PUT':
            case 'PATCH': {
                return [
                    'product.name'     => 'required|string|max:255',
                    'product.sku'      => 'max:255',
                    'product.old_sku'  => 'max:255',
                    'product.type_id'  => 'required|exists:product_types,id',
                    'product.enabled'  => 'required|boolean',
                    'product.warranty' => 'required|boolean',
                    'product.for_preorder' => 'required|boolean',
                    'product.service'  => 'required|boolean',
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
            'product.name'     => trans('site::product.name'),
            'product.sku'      => trans('site::product.sku'),
            'product.old_sku'  => trans('site::product.old_sku'),
            'product.type_id'  => trans('site::product.type_id'),
            'product.enabled'  => trans('site::product.enabled'),
            'product.warranty' => trans('site::product.warranty'),
            'product.for_preorder' => trans('site::product.for_preorder'),
            'product.service'  => trans('site::product.service'),
        ];
    }
}
