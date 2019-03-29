<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AuthorizationRoleRequest extends FormRequest
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
                    'authorization_role.name'            => 'required|string|max:255',
                    'authorization_role.title'           => 'required|string|max:255',
                    'authorization_role.address_type_id' => 'required|exists:address_types,id',
                    'authorization_role.role_id'         => 'required|unique:authorization_roles,role_id',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'authorization_role.name'            => 'required|string|max:255',
                    'authorization_role.title'           => 'required|string|max:255',
                    'authorization_role.address_type_id' => 'required|exists:address_types,id',
                    'authorization_role.role_id' => [
                        'required',
                        'unique:authorization_roles,role_id,' . $this->route()->parameter('authorization_role')->id,
                    ],
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
            'authorization_role.name'    => trans('site::authorization_role.name'),
            'authorization_role.title'   => trans('site::authorization_role.title'),
            'authorization_role.role_id' => trans('site::authorization_role.role_id'),
        ];
    }
}
