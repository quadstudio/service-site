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
        switch ($this->method()) {
            case 'POST': {
                return [
                    'display'               => 'required|boolean',
                    'active'                => 'required|boolean',
                    'dealer'                => 'required|boolean',
                    'verified'              => 'required|boolean',
//                    'region_id'             => 'required|exists:regions,id',
                    //
                    'name'                  => 'required|string|max:255',
                    'email'                 => 'required|string|email|max:255|unique:users',
                    'web'                   => 'max:255',
                    //
                    'address.sc.name'       => 'required|string|max:255',
                    'address.sc.country_id' => 'required|exists:countries,id',
                    'address.sc.region_id'  => 'required|exists:regions,id',
                    'address.sc.locality'   => 'required|string|max:255',
                    //
                    'phone.sc.country_id'   => 'required|exists:countries,id',
                    'phone.sc.number'       => 'required|string|size:' . config('site.phone.maxlength'),
                    'phone.sc.extra'        => 'max:20',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'user.display'  => 'required|boolean',
                    'user.active'   => 'required|boolean',
                    'user.dealer'   => 'required|boolean',
                    'user.verified' => 'required|boolean',
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
            'display'               => trans('site::user.display'),
            'active'                => trans('site::user.active'),
            'name'                  => trans('site::user.name'),
            'email'                 => trans('site::user.email'),
            'web'                   => trans('site::user.web'),
//            'region_id'             => trans('site::user.region_id'),
            //
            'phone.sc.country_id'   => trans('site::phone.country_id'),
            'phone.sc.number'       => trans('site::phone.number'),
            'phone.sc.extra'        => trans('site::phone.extra'),
            //
            'address.sc.name'       => trans('site::address.name'),
            'address.sc.country_id' => trans('site::address.country_id'),
            'address.sc.region_id'  => trans('site::address.region_id'),
            'address.sc.locality'   => trans('site::address.locality'),
        ];
    }
}
