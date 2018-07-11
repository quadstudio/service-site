<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

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
                    'contragent.organization_id' => 'required|exists:' . $prefix . 'organizations,id',
                    'contragent.currency_id'     => 'required|exists:' . $prefix . 'currencies,id',
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
            'contragent.organization_id' => trans('site::contragent.organization_id'),
            'contragent.currency_id'     => trans('site::contragent.currency_id'),
        ];
    }
}
