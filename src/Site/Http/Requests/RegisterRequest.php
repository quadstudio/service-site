<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        $prefix = env('DB_PREFIX', '');
        switch ($this->method()) {
            case 'GET':
            case 'DELETE': {
                return [];
            }
            case 'POST': {
                return [
                    'name'                      => 'required|string|max:255',
                    'email'                     => 'required|string|email|max:191|unique:' . $prefix . 'users',
                    'password'                  => 'required|string|min:6|confirmed',
                    'type_id'                   => 'required|exists:' . $prefix . 'contragent_types,id',
                    'web'                       => 'max:255',
                    //
                    'contact.name'              => 'required|string|max:255',
                    'contact.position'          => 'max:255',
                    //
                    'phone.contact.country_id'  => 'required|exists:' . $prefix . 'countries,id',
                    'phone.contact.number'      => 'required|numeric|digits:10',
                    'phone.contact.extra'       => 'max:20',

                    //
                    'address.sc.name'           => 'required|string|max:255',
                    'address.sc.country_id'     => 'required|exists:' . $prefix . 'countries,id',
                    'address.sc.region_id'      => 'sometimes|exists:' . $prefix . 'regions,id',
                    'address.sc.locality'       => 'required|string|max:255',
                    'address.sc.street'         => 'sometimes|max:255',
                    'address.sc.building'       => 'required|string|max:255',
                    'address.sc.apartment'      => 'sometimes|max:255',
                    //
                    'phone.sc.country_id'       => 'required|exists:' . $prefix . 'countries,id',
                    'phone.sc.number'           => 'required|numeric|digits:10',
                    'phone.sc.extra'            => 'max:20',
                    //
                    'contragent.type_id'        => 'required|exists:' . $prefix . 'contragent_types,id',
                    'contragent.name'           => 'required|string|max:255',
                    //
                    'address.legal.country_id'  => 'required|exists:' . $prefix . 'countries,id',
                    'address.legal.region_id'   => 'sometimes|exists:' . $prefix . 'regions,id',
                    'address.legal.locality'    => 'required|string|max:255',
                    'address.legal.street'      => 'sometimes|max:255',
                    'address.legal.building'    => 'required|string|max:255',
                    'address.legal.apartment'   => 'sometimes|max:255',
                    //
                    'address.postal.country_id' => 'required|exists:' . $prefix . 'countries,id',
                    'address.postal.region_id'  => 'sometimes|exists:' . $prefix . 'regions,id',
                    'address.postal.locality'   => 'required|string|max:255',
                    'address.postal.street'     => 'sometimes|max:255',
                    'address.postal.building'   => 'required|string|max:255',
                    'address.postal.apartment'  => 'sometimes|max:255',
                    //
                    'contragent.inn'            => array(
                        'required',
                        'numeric',
                        'unique:' . $prefix . 'contragents,inn',
                        'regex:/\d{10}|\d{12}/'
                    ),
                    'contragent.ogrn'           => array(
                        'required',
                        'numeric',
                        function ($attribute, $value, $fail) {
                            if ($this->input('contragent.type_id') == 1 && strlen($value) != 13) {
                                return $fail(trans('site::contragent.placeholder.ogrn'));
                            }
                            if ($this->input('contragent.type_id') == 0 && strlen($value) != 15) {
                                return $fail(trans('site::contragent.placeholder.ogrn'));
                            }
                        }
                    ),
                    'contragent.okpo'           => array(
                        'required',
                        'numeric',
                        function ($attribute, $value, $fail) {
                            if (!in_array(strlen($value), [8, 10])) {
                                return $fail(trans('site::contragent.placeholder.okpo'));
                            }
                        }
                    ),
                    'contragent.kpp'            => array(
                        'sometimes',
                        'required_if:contragent.type_id,1',
                        function ($attribute, $value, $fail) {
                            if ($this->input('contragent.type_id') == 1 && strlen($value) != 9) {
                                return $fail(trans('site::contragent.placeholder.kpp'));
                            }
                        }
                        //'regex:/^([0-9]{9})?$/'
                    ),
//                    'contragent.ks'             => 'sometimes|digits:20',
                    'contragent.rs'             => 'required|numeric|digits:20',
                    'contragent.bik'            => array(
                        'required',
                        function ($attribute, $value, $fail) {
                            if (!in_array(strlen($value), [9, 11])) {
                                return $fail(trans('site::contragent.placeholder.bik'));
                            }
                        }
                    ),
                    'contragent.bank'           => 'required|string|max:255',
                    'contragent.nds'            => 'required|boolean',
                    //

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
            'contragent.inn.regex'       => trans('site::contragent.placeholder.inn'),
            'contragent.inn.unique'      => trans('site::contragent.error.inn.unique'),
            'contragent.ogrn.regex'      => trans('site::contragent.placeholder.ogrn'),
            'contragent.okpo.regex'      => trans('site::contragent.placeholder.okpo'),
            'contragent.kpp.required_if' => trans('site::contragent.placeholder.kpp'),
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
            'name'                      => trans('site::user.name'),
            'email'                     => trans('site::user.email'),
            'password'                  => trans('site::user.password'),
            'type_id'                   => trans('site::user.type_id'),
            'web'                       => trans('site::user.web'),
            //
            'contact.name'              => trans('site::contact.name'),
            'contact.position'          => trans('site::contact.position'),
            //
            'phone.contact.country_id'  => trans('site::phone.country_id'),
            'phone.contact.number'      => trans('site::phone.number'),
            'phone.contact.extra'       => trans('site::phone.extra'),
            //
            'phone.sc.country_id'       => trans('site::phone.country_id'),
            'phone.sc.number'           => trans('site::phone.number'),
            'phone.sc.extra'            => trans('site::phone.extra'),
            //
            'contragent.type_id'        => trans('site::contragent.type_id'),
            'contragent.name'           => trans('site::contragent.name'),
            //
            'contragent.inn'            => trans('site::contragent.inn'),
            'contragent.ogrn'           => trans('site::contragent.ogrn'),
            'contragent.okpo'           => trans('site::contragent.okpo'),
            'contragent.kpp'            => trans('site::contragent.kpp'),
            'contragent.rs'             => trans('site::contragent.rs'),
            'contragent.ks'             => trans('site::contragent.ks'),
            'contragent.bik'            => trans('site::contragent.bik'),
            'contragent.bank'           => trans('site::contragent.bank'),
            'contragent.nds'            => trans('site::contragent.nds'),
            //
            'address.sc.name'           => trans('site::address.name'),
            'address.sc.country_id'     => trans('site::address.country_id'),
            'address.sc.region_id'      => trans('site::address.region_id'),
            'address.sc.locality'       => trans('site::address.locality'),
            'address.sc.street'         => trans('site::address.street'),
            'address.sc.building'       => trans('site::address.building'),
            'address.sc.apartment'      => trans('site::address.apartment'),
            //
            'address.legal.country_id'  => trans('site::address.country_id'),
            'address.legal.region_id'   => trans('site::address.region_id'),
            'address.legal.locality'    => trans('site::address.locality'),
            'address.legal.street'      => trans('site::address.street'),
            'address.legal.building'    => trans('site::address.building'),
            'address.legal.apartment'   => trans('site::address.apartment'),
            //
            'address.postal.country_id' => trans('site::address.country_id'),
            'address.postal.region_id'  => trans('site::address.region_id'),
            'address.postal.locality'   => trans('site::address.locality'),
            'address.postal.street'     => trans('site::address.street'),
            'address.postal.building'   => trans('site::address.building'),
            'address.postal.apartment'  => trans('site::address.apartment'),

        ];
    }
}
