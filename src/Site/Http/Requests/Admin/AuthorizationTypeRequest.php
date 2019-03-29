<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AuthorizationTypeRequest extends FormRequest
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
            case 'PATCH':
            case 'POST': {
                return [
                    'authorization_type.name'     => 'required|string|max:255',
                    'authorization_type.brand_id' => 'required|exists:authorization_brands,id',
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
            'authorization_type.name'     => trans('site::authorization_type.name'),
            'authorization_type.brand_id' => trans('site::authorization_type.brand_id'),
        ];
    }
}
