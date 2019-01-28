<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartItem extends FormRequest
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
            case 'GET': {
                return [];
            }
            case 'DELETE': {
                return [
                    'product_id' => 'required',
                ];
            }
            case 'POST': {
                $rules = [
                    'product_id' => 'required',
                    'name'       => 'required|string|max:255',
                    'price'      => 'required|numeric',
                    'quantity'   => 'required|integer|between:1,' . config('cart.item_max_quantity', 99)
                ];

                if (config('cart.url') === true) {
                    $rules['url'] = 'required|string|max:255';
                }
                if (config('cart.image', false) === true) {
                    $rules['image'] = 'required|string|max:255';
                }

                if (config('cart.brand', false) === true) {
                    $rules['brand_id'] = 'required|string|max:255';
                }
                if (config('cart.availability', false) === true) {
                    $rules['availability'] = 'required|boolean';
                }
                if (config('cart.sku', false) === true) {
                    $rules['sku'] = 'required|string|max:255';
                }
                if (config('cart.unit', false) === true) {
                    $rules['unit'] = 'required|string|max:10';
                }
                if (config('cart.weight', false) === true) {
                    $rules['weight'] = 'required|numeric';
                }

                return $rules;
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'product_id' => 'required',
                    'quantity'   => 'required|integer|between:1,' . config('cart.item_max_quantity', 99)
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
        return [
            'product_id.required' => trans('site::cart.product_id_required'),
            'name.required'       => trans('site::cart.name_required'),
            'price.required'      => trans('site::cart.name_required'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'product_id' => trans('site::cart.product_id'),
            'name'       => trans('site::cart.name'),
            'price'      => trans('site::cart.price'),
            'quantity'   => trans('site::cart.quantity'),
            'weight'     => trans('site::cart.weight'),
            'brand_id'   => trans('site::cart.brand_id'),
            'image'      => trans('site::cart.image'),
            'sku'        => trans('site::cart.sku'),
            'unit'       => trans('site::cart.unit'),
        ];
    }
}
