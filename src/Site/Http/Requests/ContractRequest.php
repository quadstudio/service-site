<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
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
            case 'PATCH':
            case 'POST': {
                $rules = [
                    'contract.number'        => 'required|string|max:255',
                    'contract.contragent_id' => 'required|exists:contragents,id',
                    'contract.date'          => 'required|date_format:"d.m.Y"',
                    'contract.signer'        => 'required|string|max:255',
                    'contract.phone'         => 'required|string|max:50',
                    'contract.territory'     => 'required|string|max:255',
                ];

                return $rules;
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
            'contract.number'        => trans('site::contact.number'),
            'contract.contragent_id' => trans('site::contact.contragent_id'),
            'contract.date'          => trans('site::contact.date'),
            'contract.signer'        => trans('site::contact.signer'),
            'contract.phone'         => trans('site::contact.phone'),
            'contract.territory'     => trans('site::contact.territory'),
        ];
    }
}
