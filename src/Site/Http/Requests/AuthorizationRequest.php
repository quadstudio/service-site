<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use QuadStudio\Rbac\Models\Role;

class AuthorizationRequest extends FormRequest
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
                    'authorization.role_id'    => 'required|exists:roles,id',
                    'address_id' => [
                        'required',
                        'exists:addresses,id',
                        Rule::exists('addresses', 'id')->where(function ($query) {
                            $query
                                ->where('addresses.addressable_type', 'users')
                                ->where('addresses.addressable_id', $this->user()->id);
                        }),
                    ],
                    'authorization_types'      => 'required|array'


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

        $authorization_types = trans('site::authorization_type.authorization_types');
        if($this->isMethod('post') && $this->filled('authorization.role_id')){
            $authorization_types = (Role::query()->find($this->input('authorization.role_id')))->authorization_role->title;
        }
        return [
            'authorization.type_id'    => trans('site::authorization.type_id'),
            'address_id' => trans('site::authorization.address_id'),
            'authorization_types'      => $authorization_types,
        ];
    }
}
