<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $prefix = env('DB_PREFIX', '');
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            case 'POST': {
                return [];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    //'name'          => 'required|string|max:255',
                    //'sc'            => 'required|string|max:255',
                    //'web'           => 'max:255',
                    //'email'         => 'required|string|email|max:255|unique:' .$prefix . 'users,email,' . $this->route()->parameter('user')->id,
                    'user.display'       => 'required|boolean',
                    'user.active'        => 'required|boolean',
                    'user.price_type_id' => 'required|exists:' . $prefix . 'price_types,id',
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
            'user.price_type_id' => trans('site::user.price_type_id'),
            'user.display'       => trans('site::user.display'),
            'user.active'        => trans('site::user.active'),
        ];
    }
}
