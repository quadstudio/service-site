<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EngineerRequest extends FormRequest
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
                    'name'       => 'required|string|max:255',
                    'country_id' => 'required|exists:countries,id',
                    'phone'      => 'required|numeric|digits:10',
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
            'name'       => trans('site::engineer.name'),
            'country_id' => trans('site::engineer.country_id'),
            'phone'      => trans('site::engineer.phone'),
        ];
    }
}
