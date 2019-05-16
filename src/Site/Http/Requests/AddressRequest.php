<?php

namespace QuadStudio\Service\Site\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
                    'address.type_id'    => 'required|exists:address_types,id',
                    'address.name'       => 'required_if:address.type_id,2,5,6|max:255',
                    'address.country_id' => 'required|exists:countries,id',
                    'address.region_id'  => 'required|exists:regions,id',
                    'address.locality'   => 'required|string|max:255',
                    'address.street'     => 'nullable|max:255',
                    'address.building'   => 'nullable|max:255',
                    'address.apartment'  => 'nullable|max:255',
                    'address.email'      => 'nullable|required_if:address.type_id,6|email',
                    'address.web'        => 'nullable|required_if:address.type_id,5|max:255',
                    //
                    'phone.country_id'   => 'required|exists:countries,id',
                    'phone.number'       => 'required|string|size:' . config('site.phone.maxlength'),
                    'phone.extra'        => 'max:20',
                ];
            }
            case 'PUT':
            case 'PATCH': {
                return [
                    'address.name'       => 'required_if:address.type_id,2|max:255',
                    'address.country_id' => 'required|exists:countries,id',
                    'address.region_id'  => 'required|exists:regions,id',
                    'address.locality'   => 'required|string|max:255',
                    'address.street'     => 'nullable|max:255',
                    'address.building'   => 'nullable|max:255',
                    'address.apartment'  => 'nullable|max:255',
                    'address.sort_order' => 'numeric|min:0|max:200',
                    'address.email'      => 'nullable|required_if:address.type_id,6|email',
                    'address.web'        => 'nullable|required_if:address.type_id,5|max:255',
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
            'address.email.required_if' => trans('site::address.error.required_if.email'),
            'address.web.required_if'   => trans('site::address.error.required_if.web'),
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
            //
            'address.type_id'    => trans('site::address.type_id'),
            'address.name'       => trans('site::address.name'),
            'address.country_id' => trans('site::address.country_id'),
            'address.region_id'  => trans('site::address.region_id'),
            'address.locality'   => trans('site::address.locality'),
            'address.street'     => trans('site::address.street'),
            'address.building'   => trans('site::address.building'),
            'address.apartment'  => trans('site::address.apartment'),
            'address.sort_order' => trans('site::address.sort_order'),
            'address.email'      => trans('site::address.email'),
            'address.web'        => trans('site::address.web'),
            //
            'phone.country_id'   => trans('site::phone.country_id'),
            'phone.number'       => trans('site::phone.number'),
            'phone.extra'        => trans('site::phone.extra'),
        ];
    }
}
