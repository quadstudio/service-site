<?php

namespace QuadStudio\Service\Site\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
                    'type_id'   => 'required|exists:event_types,id',
                    'region_id' => 'required|exists:regions,id',
                    'city'      => 'required|string|max:100',
                    'name'      => 'required|string|max:255',
                    'contact'   => 'required|string|max:255',
                    'phone'     => 'required|digits:10',
                    'email'     => 'required|string|max:50',
                    'count'     => 'required|numeric|min:1|max:50',
                    'address'   => 'nullable|max:255',
                    'date_from' => 'required|date',
                    'date_to'   => 'required|date|after_or_equal:date_from',
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
            'date_to.after_or_equal' => trans('site::member.error.date_to.after_or_equal'),
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
            'type_id'   => trans('site::member.type_id'),
            'region_id' => trans('site::member.region_id'),
            'city'      => trans('site::member.city'),
            'name'      => trans('site::member.name'),
            'email'     => trans('site::member.email'),
            'contact'   => trans('site::member.contact'),
            'phone'     => trans('site::member.phone'),
            'count'     => trans('site::member.count'),
            'address'   => trans('site::member.address'),
            'date_from' => trans('site::member.date_from'),
            'date_to'   => trans('site::member.date_to'),
        ];
    }
}
