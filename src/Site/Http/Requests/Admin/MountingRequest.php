<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MountingRequest extends FormRequest
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
                    'mounting.status_id'      => 'required|exists:mounting_statuses,id',
                    'mounting.social_enabled' => 'required|boolean',
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
            'mounting.status_id'      => trans('site::mounting.status_id'),
            'mounting.social_enabled' => trans('site::mounting.social_enabled'),

        ];
    }
}
