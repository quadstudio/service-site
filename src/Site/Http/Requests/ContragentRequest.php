<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContragentRequest extends FormRequest
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
                    'contragent.type_id'        => 'required|exists:' . $prefix . 'contragent_types,id',
                    'contragent.name'           => 'required|string|max:255',
                    'contragent.inn'            => array(
                        'unique:' . env('DB_PREFIX', '') . 'contragents,inn,' . $this->route()->parameter('contragent')->id,
                        'required',
                        'numeric',
                        'regex:/\d{10}|\d{12}/'
                    ),
                    'contragent.ogrn'           => array(
                        'required',
                        'numeric',
                        'regex:/\d{13}|\d{15}/'
                    ),
                    'contragent.okpo'           => array(
                        'required',
                        'numeric',
                        'regex:/\d{8}|\d{10}/'
                    ),
                    'contragent.kpp'            => array(
                        'required_if:contragent.type_id,1',
                        'regex:/^(([0-9]){9})?$/'
                    ),
                    'contragent.ks'             => 'sometimes|digits:20',
                    'contragent.rs'             => 'required|numeric|digits:20',
                    'contragent.bik'            => array(
                        'required',
                        'regex:/\d{9}|\d{11}/'
                    ),
                    'contragent.bank'           => 'required|string|max:255',
                    'contragent.nds'            => 'required|boolean',
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
        return [
            'contragent.inn.regex'       => trans('site::contragent.placeholder.inn'),
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
            'contragent.type_id'        => trans('site::contragent.type_id'),
            'contragent.name'           => trans('site::contragent.name'),
            'contragent.inn'            => trans('site::contragent.inn'),
            'contragent.ogrn'           => trans('site::contragent.ogrn'),
            'contragent.okpo'           => trans('site::contragent.okpo'),
            'contragent.kpp'            => trans('site::contragent.kpp'),
            'contragent.rs'             => trans('site::contragent.rs'),
            'contragent.ks'             => trans('site::contragent.ks'),
            'contragent.bik'            => trans('site::contragent.bik'),
            'contragent.bank'           => trans('site::contragent.bank'),
            'contragent.nds'            => trans('site::contragent.nds'),
        ];
    }
}
