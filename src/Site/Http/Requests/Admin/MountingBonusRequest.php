<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MountingBonusRequest extends FormRequest
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
                    'mounting_bonus.product_id' => 'required|exists:products,id',
                    'mounting_bonus.value'      => 'required|numeric|min:0|max:10000',
                    'mounting_bonus.social'     => 'required|numeric|min:0|max:10000',
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
            'mounting_bonus.product_id' => trans('site::mounting_bonus.product_id'),
            'mounting_bonus.value'      => trans('site::mounting_bonus.value'),
            'mounting_bonus.social'     => trans('site::mounting_bonus.social'),
        ];
    }
}
