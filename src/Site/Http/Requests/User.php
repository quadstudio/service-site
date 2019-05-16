<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class User extends FormRequest
{

    //private $regex = '_^(?:(?:https?)://)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:.\d{1,3}){3})(?!(?:169.254|192.168)(?:.\d{1,3}){2})(?!172.(?:1[6-9]|2\d|3[0-1])(?:.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]-)[a-z\x{00a1}-\x{ffff}0-9]+)(?:.(?:[a-z\x{00a1}-\x{ffff}0-9]-)[a-z\x{00a1}-\x{ffff}0-9]+)(?:.(?:[a-z\x{00a1}-\x{ffff}]{2,})).?)(?::\d{2,5})?(?:[/?#]\S)?$_iuS';


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
                    'name'          => 'required|string|max:255',
                    'email'         => 'required|string|email|max:255|unique:users',
                    'password'      => 'required|string|min:6|confirmed',
                    'contact'       => 'required|string|max:255',
                    'contact_phone' => 'required|string|size:'.config('site.phone.maxlength'),
                    'sc'            => 'required|string|max:255',
                    'type_id'       => 'required',
                    'country_id'    => 'required',
                    'phone'         => 'required|string|size:'.config('site.phone.maxlength'),
                    'web'           => 'max:255',
                    'address'       => 'required|string|max:255',
                    'geo'           => 'max:23',
                    'inn'           => array(
                        'required',
                        'regex:/\d{10}|\d{12}/'
                    ),
                    'ogrn'          => array(
                        'required',
                        'regex:/\d{13}|\d{15}/'
                    ),
                    'okpo'          => array(
                        'required',
                        'regex:/.{8}|\d{10}/'
                    ),
                    'kpp'           => array(
                        'regex:/.{0}|\d{9}/'
                    ),
                    'ks'            => 'required|numeric|digits:20',
                    'rs'            => 'required|numeric|digits:20',
                    'bik'           => 'required|numeric|digits:9',
                    'bank'          => 'required|string|max:255',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [];
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
        return [
            'inn.regex'  => trans('service::messages.placeholder.inn'),
            'ogrn.regex' => trans('service::messages.placeholder.ogrn'),
            'okpo.regex' => trans('service::messages.placeholder.okpo'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'          => trans('service::messages.name'),
            'email'         => trans('service::messages.email'),
            'password'      => trans('service::messages.password'),
            'inn'           => trans('service::messages.inn'),
            'ogrn'          => trans('service::messages.ogrn'),
            'okpo'          => trans('service::messages.okpo'),
            'kpp'           => trans('service::messages.kpp'),
            'rs'            => trans('service::messages.rs'),
            'ks'            => trans('service::messages.ks'),
            'bik'           => trans('service::messages.bik'),
            'bank'          => trans('service::messages.bank'),
            'geo'           => trans('service::messages.geo'),
            'address'       => trans('service::messages.address'),
            'web'           => trans('service::messages.web'),
            'phone'         => trans('service::messages.phone'),
            'sc'            => trans('service::messages.sc'),
            'contact_phone' => trans('service::messages.contact_phone'),
            'type_id'       => trans('service::messages.type_id'),
            'country_id'    => trans('service::messages.country_id'),
        ];
    }
}
