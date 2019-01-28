<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ParticipantRequest extends FormRequest
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
            case 'PUT':
            case 'PATCH':
            case 'POST': {
                return [
                    'name'         => 'required|string|max:100',
                    'headposition' => 'required|string|max:100',
                    'phone'        => 'nullable|digits:10',
                    'email'        => 'nullable|email|max:50'
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

            'name'         => trans('site::member.organization'),
            'headposition' => trans('site::member.headposition'),
            'phone'        => trans('site::member.phone'),
            'email'        => trans('site::member.email'),

        ];
    }
}
