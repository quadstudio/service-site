<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LaunchRequest extends FormRequest
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
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'name'            => 'required|string|max:255',
                    'country_id'      => 'required',
                    'phone'           => 'required|numeric|digits:10',
                    'address'         => 'required|string|max:255',
                    'document_name'   => 'required|string|max:255',
                    'document_number' => 'required|string|max:255',
                    'document_who'    => 'required|string|max:255',
                    'document_date'   => 'required|date_format:"Y-m-d"',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'country_id' => 'required',
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
            'name'            => trans('site::launch.name'),
            'address'         => trans('site::launch.address'),
            'country_id'      => trans('site::launch.country_id'),
            'phone'           => trans('site::launch.phone'),
            'document_name'   => trans('site::launch.document_name'),
            'document_number' => trans('site::launch.document_number'),
            'document_who'    => trans('site::launch.document_who'),
            'document_date'   => trans('site::launch.document_date'),
        ];
    }
}
