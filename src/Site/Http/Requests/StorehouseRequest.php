<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorehouseRequest extends FormRequest
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
            case 'POST': {
                return [
                    'storehouse.name' => 'required|string|max:255',
                    'storehouse.url'  => 'sometimes|string|url',
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
            'storehouse.name' => trans('site::storehouse.name'),
            'storehouse.url'  => trans('site::storehouse.url'),
        ];
    }
}
