<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhoneRequest extends FormRequest
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

            case 'POST': {
                return [
                    'country_id'   => 'required|exists:countries,id',
                    'number'       => 'required|numeric|digits:10',
                    'extra'        => 'max:20',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [

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
            'country_id'   => trans('site::phone.country_id'),
            'number'       => trans('site::phone.number'),
            'extra'        => trans('site::phone.extra'),
        ];
    }
}
